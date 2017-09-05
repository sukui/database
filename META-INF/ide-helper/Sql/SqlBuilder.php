<?php

namespace Zan\Framework\Store\Database\Sql;

class SqlBuilder
{
    private $SqlBuilder;

    public function __construct()
    {
        $this->SqlBuilder = new \ZanPHP\Database\Sql\SqlBuilder();
    }

    public function setSqlMap($sqlMap)
    {
        $this->SqlBuilder->setSqlMap($sqlMap);
    }

    public function getSqlMap()
    {
        $this->SqlBuilder->getSqlMap();
    }

    public function builder($data, $options)
    {
        $this->SqlBuilder->builder($data, $options);
    }
}