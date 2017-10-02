<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/10/2
 * Time: 15:56
 */

namespace Phpbox\Redis;

use Psr\Log\LogLevel;

class Config
{
    private $config = array(
        'log_level' => LogLevel::INFO,
        'host'      => '',
        'pass'      => '',
        'port'      => '',
        'timeout'   => 0,
        'pconnect'  => true,
    );


    public function set($key, $value)
    {
        if (isset($this->config[$key])) {
            $this->config[$key] = $value;
        }

        return $this;
    }

    public function get($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }
}