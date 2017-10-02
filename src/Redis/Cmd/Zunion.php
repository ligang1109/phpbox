<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 17:13
 */

namespace Phpbox\Redis\Cmd;


class Zunion extends Base
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'zunionstore';
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        $cmd = $this->getCmd() . ' ' . $this->escape($args[0]);
        $cmd .= ' ' . $this->escape(count($args[1]));

        foreach ($args[1] as $value) {
            $cmd .= ' ' . $this->escape($value);
        }

        if (isset($args[2]) && !empty($args[2])) {
            $cmd .= ' ' . $this->escape('weights');
            foreach ($args[2] as $value) {
                $cmd .= ' ' . $this->escape($value);
            }

            if (isset($args[3]) && $args[3] != '') {
                $cmd .= ' ' . $this->escape('aggregate') . ' ' . $this->escape($args[3]);
            }
        }

        return $cmd;
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}