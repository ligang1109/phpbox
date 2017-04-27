<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/4
 * Time: 10:15
 */

namespace Phpbox\Core\Action;

use Phpbox\Core\WebContext;

abstract class WebErrorBase
{
    abstract public function run(WebContext $context, \Exception $e);
}