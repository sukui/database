<?php
namespace Zan\Framework\Store\Database\Sql;

class Validator
{
    public static function realEscape($value, $callback = null)
    {
        \ZanPHP\Database\Sql\Validator::realEscape($value, $callback);
    }
}