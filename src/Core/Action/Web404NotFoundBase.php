<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/4
 * Time: 10:28
 */

namespace Phpbox\Core\Action;

use Phpbox\Core\WebContext;

abstract class Web404NotFoundBase
{
    abstract public function run(WebContext $context);
}