<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 15:05
 */

namespace Phpbox\Redis\Cmd;


class Saddarray extends Base
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return "sadd";
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        $cmd = $this->getCmd() . ' ' . $this->escape($args[0]);
        foreach ($args[1] as $value) {
            $cmd.= " " . $this->escape($value);
        }

        return $cmd;
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}