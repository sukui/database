<?php
namespace Zan\Framework\Store\Database;

use ZanPHP\Contracts\Database\DbResultInterface;
use ZanPHP\Contracts\Database\ResultFormatterInterface;
use ZanPHP\Contracts\Database\ResultTypeInterface;

class ResultFormatter implements ResultFormatterInterface
{
    private $ResultFormatter;

    public function __construct(DbResultInterface $result, $resultType = ResultTypeInterface::RAW)
    {
        $this->ResultFormatter = new \ZanPHP\Database\ResultFormatter($result, $resultType);
    }

    public function format()
    {
        $this->ResultFormatter->format();
    }
}