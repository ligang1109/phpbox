<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 14:57
 */

namespace Phpbox\Redis\Cmd;


abstract class WriteIndexArgs extends Base
{
    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        return $this->makeIndexArgsCmd($args);
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}