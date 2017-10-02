<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 15:05
 */

namespace Phpbox\Redis\Cmd;


class Blpop extends Base
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return "blpop";
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        if (is_array($args[0])) {
            $cmd     = $this->makeIndexArgsCmd($args[0]);
            $timeout = isset($args[1]) ? $args[1] : 0;

            return "$cmd " . $this->escape($timeout);
        }

        return $this->makeIndexArgsCmd($args);
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}