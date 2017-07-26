<?php
namespace Zan\Framework\Store\Database\Mysql;

use Zan\Framework\Contract\Store\Database\DbResultInterface;
use Zan\Framework\Contract\Store\Database\DriverInterface;

class MysqliResult implements DbResultInterface
{
    /**
     * FutureResult constructor.
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {

    }

    /**
     * @return int
     */
    public function getLastInsertId()
    {

    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {

    }

    /**
     * @return array
     */
    public function fetchRows()
    {

    }

    public function getCountRows()
    {

    }
}