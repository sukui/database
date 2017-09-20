<?php

namespace Zan\Framework\Store\Database;

class Flow
{
    private $Flow;

    public function __construct()
    {
        $this->Flow = new \ZanPHP\Database\Flow();
    }

    public function query($sid, $data, $options)
    {
        $this->Flow->query($sid, $data, $options);
    }

    public function queryRaw($table, $sql)
    {
        $this->Flow->queryRaw($table, $sql);
    }

    public function beginTransaction($flags = 0)
    {
        $this->Flow->beginTransaction($flags);
    }

    public function commit($flags = 0)
    {
        $this->Flow->commit($flags);
    }

    public function rollback($flags = 0)
    {
        $this->Flow->rollback($flags);
    }

    public function terminate()
    {
        $this->Flow->terminate();
    }
}
