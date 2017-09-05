<?php

namespace Zan\Framework\Store\Database\Sql;

class SqlMap
{
    private $SqlMap;

    public function __construct()
    {
        $this->SqlMap = new \ZanPHP\Database\Sql\SqlMap();
    }

    public function setSqlMaps($sqlMaps)
    {
        $this->SqlMap->setSqlMaps($sqlMaps);
    }

    public function getSql($sid, $data = [], $options = [])
    {
        $this->SqlMap->getSql($sid, $data, $options);
    }
}



