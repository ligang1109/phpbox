<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/4
 * Time: 10:14
 */

namespace Phpbox\Core\Action;

use Phpbox\Core\Context;

abstract class ErrorBase
{
    abstract public function run(Context $context, \Exception $e);
}