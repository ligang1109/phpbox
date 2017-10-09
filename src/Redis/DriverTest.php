<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/7/24
 * Time: 18:09
 */

namespace Phpbox\Redis;

use Phpbox\Log\Formater\General;
use Phpbox\Log\Logger;
use Phpbox\Log\Writer\File;
use PHPUnit\Framework\TestCase;


class DriverTest extends TestCase
{
    public function driverProvider()
    {
        $config = new Config();
        $config->set('host', '127.0.0.1')
               ->set('port', '6379')
               ->set('pass', 123);
        $formater = new General();
        $writer   = new File('/tmp/test_redis.log');
        $driver   = new Driver($config, new Logger($formater, $writer));

        return array(
            array($driver),
        );
    }

    /**
     * @dataProvider driverProvider
     * @param $driver Driver
     */
    public function testInsertOneFindOne($driver)
    {
        $driver->RunCmd('set', array('a', 1));

        $this->assertEquals($driver->RunCmd('get', array('a')), 1);
    }
}