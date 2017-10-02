<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 18:29
 */

namespace Phpbox\Redis\Cmd;


class Hdel extends WriteIndexArgs
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'hdel';
    }
}