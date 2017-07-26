<?php

namespace Zan\Framework\Store\Database\Mysql;

use Zan\Framework\Contract\Store\Database\DbResultInterface;
use Zan\Framework\Contract\Store\Database\DriverInterface;
use Zan\Framework\Contract\Network\Connection;
use Zan\Framework\Store\Database\Mysql\Exception\MysqliQueryException;
use ZanPHP\Coroutine\Contract\Async;


class Mysql implements DriverInterface, Async
{
    const DEFAULT_QUERY_TIMEOUT = 3000;

    public function getConnection()
    {

    }

    public function setCountAlias($countAlias)
    {

    }

    public function getCountAlias()
    {

    }

    public function getResult()
    {

    }

    public function execute(callable $callback, $task)
    {

    }

    /**
     * @param $sql
     * @return \Generator
     * @throws MysqliQueryException
     */
    public function query($sql)
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

    public function __construct(Connection $conn)
    {

    }

    /**
     * @param $link
     * @param $result
     * @return DbResultInterface
     */
    public function onSqlReady($link, $result)
    {
        // TODO: Implement onSqlReady() method.
    }
}