<?php
namespace Zan\Framework\Store\Database;

use Zan\Framework\Foundation\Core\Config;
use Zan\Framework\Foundation\Core\Debug;
use Zan\Framework\Store\Database\Mysql\Exception\MysqliTransactionException;
use Zan\Framework\Store\Database\Mysql\Mysql;
use Zan\Framework\Store\Database\Mysql\MysqliResult;
use Zan\Framework\Store\Database\Sql\SqlMap;
use Zan\Framework\Store\Database\Sql\Table;
use Zan\Framework\Network\Connection\ConnectionManager;
use Zan\Framework\Contract\Network\Connection;
use Zan\Framework\Store\Database\Exception\CanNotFindDatabaseEngineException;
use Zan\Framework\Store\Database\Exception\DbCommitFailException;
use Zan\Framework\Store\Database\Exception\CanNotGetConnectionByStackException;
use Zan\Framework\Store\Database\Exception\CanNotGetConnectionByConnectionManagerException;
use Zan\Framework\Store\Database\Exception\DbRollbackFailException;

use Zan\Framework\Store\Database\Mysql\Exception\MysqliConnectionLostException;
use Zan\Framework\Store\Database\Mysql\Exception\MysqliQueryException;
use Zan\Framework\Store\Database\Mysql\Exception\MysqliQueryTimeoutException;
use Zan\Framework\Store\Database\Mysql\Exception\MysqliSqlSyntaxException;
use Zan\Framework\Store\Database\Mysql\Exception\MysqliQueryDuplicateEntryUniqueKeyException;

use SplStack;
use Zan\Framework\Utilities\Types\ObjectArray;

class Flow
{
    /**
     * 以Task为单位标记是否开启事务
     */
    const BEGIN_TRANSACTION_FLAG = 'begin_transaction_%s';
    /**
     * 在Context里储存开启事务的的链接的Key, 以Task和DatabaseName为单位
     */
    const CONNECTION_CONTEXT = 'connection_context_%s_%s';
    /**
     * 保存以Task为单位的开启事务的连接的栈, (目的是为了commit的时候不用传database name, 针对被调用接口有自己的事务的情况)
     */
    const CONNECTION_STACK = 'connection_stack_%s'; //format with taskId

    const CONNECTION_TASKID_STACK = 'connection_taskid_stack';

    const ACTIVE_CONNECTION_CONTEXT_KEY= 'mysql_active_connections';

    /**
     * @yield mixed(base on ResultType)
     */
    public function query($sid, $data, $options)
    {

    }

    public function queryRaw($table, $sql)
    {

    }

    public function beginTransaction($flags = 0)
    {

    }

    public function commit($flags = 0)
    {

    }

    public function rollback($flags = 0)
    {

    }

    public function terminate()
    {

    }
}
