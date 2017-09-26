<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/26
 * Time: 下午2:44
 */

namespace ZanPHP\Database\Tests;

use ZanPHP\Database\Sql\SqlMapInitiator;
use ZanPHP\Database\Sql\Table;
use ZanPHP\ConnectionPool\ConnectionInitiator;
use ZanPHP\SPI\ServiceLoader;
use ZanPHP\Container\Container;
use ZanPHP\Config\Config;

use ZanPHP\Testing\TaskTest;

class TaskTestCase extends TaskTest
{
    private static $configPath;
    private static $runMode;

    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $serviceLoader = ServiceLoader::getInstance();
        $serviceLoader->scan(__DIR__.'/../vendor');
        $services = ServiceLoader::getInstance()->load();
        $container = Container::getInstance();
        foreach ($services as $interface => $serviceProviders) {
            foreach ($serviceProviders as $serviceProvider) {
                $container->bind($serviceProvider["id"], $serviceProvider["class"], $serviceProvider["shared"]);
            }
        }

        self::$runMode = getenv('runMode');
        self::$configPath = getenv('path.config');
        putenv('runMode=test');
        putenv('path.config='.__DIR__ . '/resource/config/');
        putenv('path.sql='.__DIR__ . '/resource/sql/');
        putenv('path.table='.__DIR__ . '/resource/config/share/table/');
        Config::init();

        SqlMapInitiator::getInstance()->init();
        Table::getInstance()->init();
        ConnectionInitiator::getInstance()->init('connection', null);
    }

    public static function tearDownAfterClass(){
        parent::tearDownAfterClass();
        putenv('runMode='.self::$runMode);
        putenv('path.config='.self::$configPath);
    }

    protected function setUp(){
        parent::setUp();
    }

    protected function tearDown(){
        parent::tearDown();
    }

}
