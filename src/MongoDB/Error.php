<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/8/18
 * Time: 17:45
 */

namespace Phpbox\MongoDB;


class Error
{
    const DUPLICATE_ENTRY = 'duplicate key error';

    public static function duplicateEntry(\Exception $e)
    {
        return (strpos($e->getMessage(), self::DUPLICATE_ENTRY) === false) ? false : true;
    }
}