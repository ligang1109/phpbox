<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 9:44
 */

namespace Phpbox\ParamsFilter;


class GeneralProcessor
{
    public function processStr($value)
    {
        return trim($value);
    }

    public function processInt($value)
    {
        return intval($value);
    }

    public function processFloat($value)
    {
        return floatval($value);
    }

    public function processArr($value, Filter $filter = null)
    {
        if (!is_null($filter)) {
            return $filter->run($value);
        }

        foreach ($value as $k => $v) {
            if (is_array($v)) {
                $v = $this->processArr($v);
            } else {
                $v = trim($v);
            }
            $value[$k] = $v;
        }

        return $value;
    }
}