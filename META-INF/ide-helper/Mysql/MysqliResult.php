<?php

namespace Zan\Framework\Store\Database\Mysql;

use ZanPHP\Contracts\Database\DbResultInterface;
use ZanPHP\Contracts\Database\DriverInterface;

class MysqliResult implements DbResultInterface
{
    private $MysqliResult;

    public function __construct(DriverInterface $driver)
    {
        $this->MysqliResult = new \ZanPHP\Database\Mysql\MysqliResult($driver);
    }

    public function getLastInsertId()
    {
        $this->MysqliResult->getLastInsertId();
    }

    public function getAffectedRows()
    {
        $this->MysqliResult->getAffectedRows();
    }

    public function fetchRows()
    {
        $this->MysqliResult->fetchRows();
    }

    public function getCountRows()
    {
        $this->MysqliResult->getCountRows();
    }
}