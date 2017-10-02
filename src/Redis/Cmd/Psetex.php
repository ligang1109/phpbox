<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 14:42
 */

namespace Phpbox\Redis\Cmd;


class Psetex extends WriteIndexArgs
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'psetex';
    }
}