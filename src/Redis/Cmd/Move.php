<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 15:05
 */

namespace Phpbox\Redis\Cmd;


class Move extends WriteIndexArgs
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return "move";
    }
}