<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/21
 * Time: 15:39
 */

namespace Phpbox\Redis\Cmd;

use Psr\Log\LoggerInterface;

class Tool
{
    public static function newRedisCmd($cmd)
    {
        $clsname = '\Phpbox\Redis\Cmd\\'.ucfirst($cmd);

        return class_exists($clsname) ? new $clsname() : new General($cmd);
    }
}