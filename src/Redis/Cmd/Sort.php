<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/24
 * Time: 16:59
 */

namespace Phpbox\Redis\Cmd;


class Sort extends Base
{
    public function getCmd()
    {
        // TODO: Implement getCmd() method.
        return 'sort';
    }

    public function getRunCmd(array $args)
    {
        // TODO: Implement getRunCmd() method.
        $cmd = $this->getCmd() . ' ' . $this->escape($args[0]);
        $params = $args[1];
        if (isset($params['by'])) {
            $cmd .= ' ' . $this->escape('by') . ' ' . $this->escape($params['by']);
        }
        if (isset($params['limit'])) {
            $cmd .= ' ' . $this->escape('limit') . ' ' . $this->escape($params['limit']);
        }
        if (isset($params['get'])) {
            if (is_array($params['get'])) {
                foreach ($params['get'] as $value) {
                    $cmd .= ' ' . $this->escape('get') . ' ' . $this->escape($value);
                }
            } else {
                $cmd .= ' ' . $this->escape('get') . ' ' . $this->escape($params['get']);
            }
        }
        if (isset($params['sort'])) {
            $cmd .= ' ' . $this->escape($params['sort']);
        }
        if (isset($params['alpha']) && $params['alpha'] === true) {
            $cmd .= ' ' . $this->escape('alpha');
        }
        if (isset($params['store'])) {
            $cmd .= ' ' . $this->escape('store') . ' ' . $this->escape($params['store']);
        }

        return $cmd;
    }

    public function needLog()
    {
        // TODO: Implement needLog() method.
        return true;
    }
}