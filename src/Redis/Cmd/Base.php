<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/21
 * Time: 15:20
 */

namespace Phpbox\Redis\Cmd;

abstract class Base
{
    /**
     * @return string
     */
    abstract public function getCmd();

    /**
     * @param array $args
     * @return string
     */
    abstract public function getRunCmd(array $args);

    /**
     * @return bool
     */
    abstract public function needLog();

    protected function makeIndexArgsCmd(array $args)
    {
        $cmd = '';
        foreach ($args as $value) {
            $cmd .= ' ' . $this->escape($value);
        }

        return $this->getCmd() . $cmd;
    }

    protected function escape($value)
    {
        return $value;
    }
}