<?php

namespace Zan\Framework\Store\Database\Sql;

class SqlParser
{
    private $SqlParser;

    public function __construct()
    {
        $this->SqlParser = new \ZanPHP\Database\Sql\SqlParser();
    }

    public function setSqlMap($sqlMap)
    {
        $this->SqlParser->setSqlMap($sqlMap);
    }

    public function parse()
    {
        $this->SqlParser->parse();
    }

    public function getSqlMap()
    {
        $this->SqlParser->getSqlMap();
    }
}
