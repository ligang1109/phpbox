<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 17:13
 */

namespace Phpbox\Redis\Cmd;


class Rpoplpush extends WriteIndexArgs
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'rpoplpush';
    }
}