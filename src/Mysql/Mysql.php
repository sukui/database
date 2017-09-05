<?php

namespace ZanPHP\Database\Mysql;

use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Contracts\Database\DriverInterface;
use ZanPHP\Contracts\Debugger\Tracer;
use ZanPHP\Contracts\Trace\Constant;
use ZanPHP\Contracts\Trace\Trace;
use ZanPHP\Coroutine\Contract\Async;
use ZanPHP\Database\Mysql\Exception\MysqliConnectionLostException;
use ZanPHP\Database\Mysql\Exception\MysqliQueryDuplicateEntryUniqueKeyException;
use ZanPHP\Database\Mysql\Exception\MysqliQueryException;
use ZanPHP\Database\Mysql\Exception\MysqliQueryTimeoutException;
use ZanPHP\Database\Mysql\Exception\MysqliSqlSyntaxException;
use ZanPHP\Exception\ZanException;
use ZanPHP\Timer\Timer;

class Mysql implements DriverInterface, Async
{
    /**
     * @var \ZanPHP\Contracts\ConnectionPool\Connection
     */
    private $connection;

    private $sql;

    /**
     * @var callable
     */
    private $callback;

    private $result;

    /**
     * @var Trace
     */
    private $trace;
    private $traceHandle;

    /**
     * @var Tracer
     */
    private $debuggerTrace;
    private $debuggerTid;

    private $countAlias;

    /** @var \swoole_mysql $swooleMysql */
    private $swooleMysql;

    const DEFAULT_QUERY_TIMEOUT = 3000;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->swooleMysql = $connection->getSocket();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function setCountAlias($countAlias)
    {
        $this->countAlias = $countAlias;
    }

    public function getCountAlias()
    {
        return $this->countAlias;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function execute(callable $callback, $task)
    {
        $this->callback = $callback;
    }

    /**
     * @param $sql
     * @return \Generator
     * @throws MysqliQueryException
     */
    public function query($sql)
    {
        $value = (yield getContext("service-chain-value"));
        if (is_array($value) && isset($value["zan_test"]) && $value["zan_test"] === true) {
            $sql = "/*!ctx:shadow*/" . $sql;
        }
        $this->trace = (yield getContext("trace"));
        if ($this->trace) {
            $this->traceHandle = $this->trace->transactionBegin(Constant::SQL, $sql);
        }

        $debuggerTrace = (yield getContext("debugger_trace"));
        if ($debuggerTrace instanceof Tracer) {
            $conf = $this->connection->getConfig();
            $dsn = "mysql:host={$conf["host"]};port={$conf["port"]};dbname={$conf["database"]}";
            $this->debuggerTid = $debuggerTrace->beginTransaction(Constant::SQL, $sql, $dsn);
            $this->debuggerTrace = $debuggerTrace;
        }

        $this->sql = $sql;
        $r = $this->swooleMysql->query($this->sql, [$this, "onSqlReady"]);
        if ($r === false) {
            throw new MysqliQueryException("mysql query fail [sql=$this->sql]");
        } else {
            $this->beginTimeoutTimer("mysql query");
            yield $this;
        }
    }

    public function beginTransaction($flags = 0)
    {
        yield $this->query("START TRANSACTION");
    }

    public function commit($flags = 0)
    {
        yield $this->query("COMMIT");
    }

    public function rollback($flags = 0)
    {
        yield $this->query("ROLLBACK");
    }

    /**
     * @param \swoole_mysql $link
     * @param array|bool $result
     * @return void|\Zan\Framework\Contract\Store\Database\DbResultInterface
     * @throws MysqliConnectionLostException
     * @throws MysqliQueryDuplicateEntryUniqueKeyException
     * @throws MysqliQueryException
     * @throws MysqliSqlSyntaxException
     */
    public function onSqlReady($link, $result = true)
    {
        if($this->callback == null) {
            return;
        }

        $this->cancelTimeoutTimer();

        $exception = null;

        if ($result === false) {

            $errno = $link->errno;
            $error = $link->error;
            if (in_array($errno, [2013, 2006])) {
                $exception = new MysqliConnectionLostException("$error:$this->sql");
            } elseif ($errno == 1064) {
                $exception = new MysqliSqlSyntaxException("$error:$this->sql");
            } elseif ($errno == 1062) {
                $exception = new MysqliQueryDuplicateEntryUniqueKeyException("$error:$this->sql");
            } else {
                $ctx = [
                    'sql' => $this->sql,
                    'errno' => $errno,
                    'error' => $error,
                ];
                $exception = new MysqliQueryException("errno=$errno&error=$error:$this->sql", 0, null, $ctx);
            }

            if ($this->trace) {
                $this->trace->commit($this->traceHandle, $exception->getTraceAsString());
            }
            if ($this->debuggerTrace) {
                $this->debuggerTrace->commit($this->debuggerTid, "error", $exception);
            }
        } else {
            if ($this->trace) {
                $this->trace->commit($this->traceHandle, Constant::SUCCESS);
            }
            if ($this->debuggerTrace) {
                $this->debuggerTrace->commit($this->debuggerTid, "info", $result);
            }
        }

        $this->result = $result;

        if ($this->callback) {
            $callback = $this->callback;
            $this->callback = null;
            $callback(new MysqliResult($this), $exception);
        }
    }

    private function beginTimeoutTimer($type)
    {
        $config = $this->connection->getConfig();
        $timeout = isset($config['timeout']) ? $config['timeout'] : self::DEFAULT_QUERY_TIMEOUT;
        Timer::after($timeout, $this->onQueryTimeout($this->sql, $type), spl_object_hash($this));
    }

    private function cancelTimeoutTimer()
    {
        Timer::clearAfterJob(spl_object_hash($this));
    }

    private function onQueryTimeout($sql, $type)
    {
        $start = microtime(true);
        return function() use($sql, $start, $type) {
            if ($this->trace) {
                $this->trace->commit($this->traceHandle, "$type timeout");
            }
            if ($this->debuggerTrace) {
                $this->debuggerTrace->commit($this->debuggerTid,"warn", "$type timeout");
            }

            if ($this->callback) {
                $duration = microtime(true) - $start;
                $ctx = [
                    "sql" => $sql,
                    "duration" => $duration,
                ];
                $callback = $this->callback;
                $this->callback = null;
                $ex = new MysqliQueryTimeoutException("Mysql $type timeout [sql=$sql, duration=$duration]", 0, null, $ctx);
                $callback(null, $ex);
            }
        };
    }

    /**
     * $dbResult类型错误,直接抛出异常,取消超时,避免超时异常再次抛出
     */
    public function onInvalidResult($dbResult)
    {
        $ctx = [
            "sql" => $this->sql,
        ];
        $this->cancelTimeoutTimer();
        sys_error(var_export($dbResult, true));
        throw new MysqliQueryException("dbResult type invalid [sql={$this->sql}]", 0, null, $ctx);
    }
}