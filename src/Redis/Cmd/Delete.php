<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 15:05
 */

namespace Phpbox\Redis\Cmd;


class Delete extends WriteIndexArgs
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return "delete";
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        if (is_array($args[0])) {
            return $this->makeIndexArgsCmd($args[0]);
        }

        return $this->makeIndexArgsCmd($args);
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}