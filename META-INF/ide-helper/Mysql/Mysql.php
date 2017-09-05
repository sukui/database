<?php

namespace Zan\Framework\Store\Database\Mysql;

use ZanPHP\Contracts\ConnectionPool\Connection;
use ZanPHP\Contracts\Database\DriverInterface;
use ZanPHP\Coroutine\Contract\Async;


class Mysql implements DriverInterface, Async
{
    private $Mysql;

    public function __construct(Connection $connection)
    {
        $this->Mysql = new \ZanPHP\Database\Mysql\Mysql($connection);
    }

    public function getConnection()
    {
        $this->Mysql->getConnection();
    }

    public function setCountAlias($countAlias)
    {
        $this->Mysql->setCountAlias($countAlias);
    }

    public function getCountAlias()
    {
        $this->Mysql->getCountAlias();
    }

    public function getResult()
    {
        $this->Mysql->getResult();
    }

    public function execute(callable $callback, $task)
    {
        $this->Mysql->execute($callback, $task);
    }

    public function query($sql)
    {
        $this->Mysql->query($sql);
    }

    public function beginTransaction($flags = 0)
    {
        $this->Mysql->beginTransaction($flags);
    }

    public function commit($flags = 0)
    {
        $this->Mysql->commit($flags);
    }

    public function rollback($flags = 0)
    {
        $this->Mysql->rollback($flags);
    }

    public function onSqlReady($link, $result)
    {
        $this->Mysql->onSqlReady($link, $result);
    }
}