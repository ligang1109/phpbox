<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 19:58
 */

namespace Phpbox\Redis\Cmd;


class Hmset extends Base
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'hmset';
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        $cmd = $this->getCmd() . ' ' . $this->escape($args[0]);
        foreach ($args[1] as $key => $value) {
            $cmd .= ' ' . $this->escape($key) . ' ' . $this->escape($value);
        }

        return $cmd;
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}