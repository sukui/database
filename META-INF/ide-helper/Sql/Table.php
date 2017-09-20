<?php

namespace Zan\Framework\Store\Database\Sql;

class Table
{
    private $Table;

    public function __construct()
    {
        $this->Table = new \ZanPHP\Database\Sql\Table();
    }

    public function getDatabase($tableName)
    {
        $this->Table->getDatabase($tableName);
    }

    public function init()
    {
        $this->Table->init();
    }
}
