<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/21
 * Time: 15:36
 */

namespace Phpbox\Redis\Cmd;


use Psr\Log\LoggerInterface;

class General extends Base
{
    private $cmd = '';

    public function __construct($cmd)
    {
        $this->cmd = $cmd;
    }

    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return $this->cmd;
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        return '';
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return false;
    }
}