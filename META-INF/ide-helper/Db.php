<?php

namespace Zan\Framework\Store\Facade;

class Db
{
    public static function execute($sid, $data, $options = [])
    {
        \ZanPHP\Database\Db::execute($sid, $data, $options);
    }
 
    public static function beginTransaction($flags = 0)
    {
        \ZanPHP\Database\Db::beginTransaction($flags);
    }
    
    public static function commit($flags = 0)
    {
        \ZanPHP\Database\Db::commit($flags);
    }
    
    public static function rollback($flags = 0)
    {
        \ZanPHP\Database\Db::rollback($flags);
    }

    public static function terminate()
    {
        \ZanPHP\Database\Db::terminate();
    }
}