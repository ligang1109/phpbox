<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 10:52
 */

namespace Phpbox\ParamsFilter;


class GeneralChecker
{
    public function checkStrNotNull($value)
    {
        return $value !== '' ? true : false;
    }

    public function checkIntNotZero($value)
    {
        return $value !== 0 ? true : false;
    }

    public function checkFloatNotZero($value)
    {
        return $value !== 0.0 ? true : false;
    }

    public function checkArrNotEmpty($value)
    {
        return !empty($value) ? true : false;
    }

    public function checkIsMd5($value)
    {
        return preg_match('/^[0-9a-f]{32}$/', $value) ? true : false;
    }

    public function checkIsNum($value)
    {
        return is_numeric($value) ? true : false;
    }

    public function checkValidDateFormat($value)
    {
        return strtotime($value) !== false ? true : false;
    }
}