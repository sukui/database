<?php

namespace ZanPHP\Database\Sql;

use ZanPHP\Contracts\Config\ConfigLoader;
use ZanPHP\Database\Sql\Exception\SqlTableException;
use ZanPHP\Support\Singleton;

class Table
{
    use Singleton;
    private $tables = [];

    public function getDatabase($tableName)
    {
        if (!isset($this->tables[$tableName])) {
            $this->setTables();
            if (!isset($this->tables[$tableName])) {
                throw new SqlTableException('无法获取数' . $tableName . '表所在的数据库配置');
            }
        }
        return $this->tables[$tableName];
    }

    public function init()
    {
        $this->setTables();
    }

    private function setTables()
    {
        if ([] == $this->tables) {
            /** @var ConfigLoader $configLoader */
            $configLoader = make(ConfigLoader::class);
            $tables = $configLoader->loadDistinguishBetweenFolderAndFile(getenv("path.table"));
            if (null == $tables || [] == $tables) {
                return;
            }
            foreach ($tables as $table) {
                if (null == $table || [] == $table) {
                    continue;
                }
                $parseTable = $this->parseTable($table);
                if ([] != $parseTable) {
                    $this->tables = array_merge($this->tables, $parseTable);
                }
            }
        }
        return;
    }

    private function parseTable($table)
    {
        $result = [];
        foreach ($table as $db => $tableList) {
            foreach ($tableList as $tableName) {
                $result[$tableName] = $db;
            }
        }
        return $result;
    }

}
