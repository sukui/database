<?php
namespace Zan\Framework\Store\Database;

use Zan\Framework\Contract\Store\Database\ResultFormatterInterface;
use Zan\Framework\Contract\Store\Database\DbResultInterface;
use Zan\Framework\Contract\Store\Database\ResultTypeInterface;

class ResultFormatter implements ResultFormatterInterface
{
    /**
     * ResultFormatterInterface constructor.
     * @param DbResultInterface $result
     * @param int $resultType
     */
    public function __construct(DbResultInterface $result, $resultType = ResultTypeInterface::RAW)
    {

    }

    /**
     * @yield mixed(base on ResultType)
     */
    public function format()
    {

    }
}