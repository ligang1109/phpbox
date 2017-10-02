<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/25
 * Time: 16:08
 */

namespace Phpbox\Redis\Cmd;

class Exec extends WriteIndexArgs
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return "exec";
    }
}