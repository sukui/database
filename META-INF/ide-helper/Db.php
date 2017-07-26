<?php

namespace Zan\Framework\Store\Facade;

class Db
{
    const RETURN_AFFECTED_ROWS  = true;
    const USE_MASTER            = true;
    const RETURN_INSERT_ID      = false;
    
    public static function execute($sid, $data, $options = [])
    {

    }
 
    public static function beginTransaction($flags = 0)
    {

    }
    
    public static function commit($flags = 0)
    {

    }
    
    public static function rollback($flags = 0)
    {

    }

    public static function terminate()
    {

    }
}