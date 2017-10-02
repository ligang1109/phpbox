<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 17:13
 */

namespace Phpbox\Redis\Cmd;


class Msetnx extends Base
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'msetnx';
    }

    public function getRunCmd(array $args)
    {
        $cmd = $this->getCmd();
        foreach ($args[0] as $key => $value) {
            $cmd .= ' ' . $this->escape($key) . ' ' . $this->escape($value);
        }

        return $cmd;
    }

    public function needLog()
    {
        return true;
    }
}