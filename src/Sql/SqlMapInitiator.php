<?php

namespace ZanPHP\Database\Sql;

use ZanPHP\Contracts\Config\ConfigLoader;
use ZanPHP\Support\Singleton;

class SqlMapInitiator
{
    use Singleton;

    public function init()
    {
        $sqlPath = getenv("path.sql");
        if (!is_dir($sqlPath)) {
            return false;
        }
        /** @var ConfigLoader $configLoader */
        $configLoader = make(ConfigLoader::class);
        $sqlMaps = $configLoader->loadDistinguishBetweenFolderAndFile($sqlPath);
        if (null == $sqlMaps || [] == $sqlMaps) {
            return false;
        }
        foreach ($sqlMaps as $key => $sqlMap) {
            $sqlMaps[$key] = (new SqlParser())->setSqlMap($sqlMap)->parse()->getSqlMap();
        }
        SqlMap::getInstance()->setSqlMaps($sqlMaps);
        return true;
    }
}