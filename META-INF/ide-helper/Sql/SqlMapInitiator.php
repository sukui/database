<?php

namespace Zan\Framework\Store\Database\Sql;

class SqlMapInitiator
{
    private $SqlMapInitiator;

    public function __construct()
    {
        $this->SqlMapInitiator = new \ZanPHP\Database\Sql\SqlMapInitiator();
    }

    public function init()
    {
        $this->SqlMapInitiator->init();
    }
}