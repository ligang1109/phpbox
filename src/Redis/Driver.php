<?php

namespace Phpbox\Redis;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/10/2
 * Time: 15:55
 */
class Driver
{
    /**
     * @var Config
     */
    private $config = null;

    /**
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * @var \Redis
     */
    private $redis = null;

    /**
     * @var Cmd\Base[]
     */
    private $cmdList = array();

    public function __construct(Config $config, LoggerInterface $logger)
    {
        $this->config = $config;
        if (is_null($logger)) {
            $logger = new NullLogger();
        }
        $this->logger = $logger;

        $this->redis = new \Redis();
        if ($this->config->get('pconnect')) {
            $this->redis->pconnect(
                $this->config->get('host'),
                $this->config->get('port'),
                $this->config->get('timeout')
            );
        } else {
            $this->redis->connect(
                $this->config->get('host'),
                $this->config->get('port'),
                $this->config->get('timeout')
            );
        }
        $this->redis->auth($this->config->get('pass'));
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function RunCmd($cmd, array $args = array())
    {
        $command = null;
        if (isset($this->cmdList[$cmd])) {
            $command = $this->cmdList[$cmd];
        } else {
            $command             = Cmd\Tool::newRedisCmd($cmd);
            $this->cmdList[$cmd] = $command;
        }

        if ($command->needLog()) {
            $this->logger->log($this->config->get('log_level'), $command->getRunCmd($args));
        }

        return call_user_func_array(array($this->redis, $cmd), $args);
    }
}