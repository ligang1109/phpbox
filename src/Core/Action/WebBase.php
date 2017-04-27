<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/4
 * Time: 10:13
 */

namespace Phpbox\Core\Action;

use Phpbox\Core\WebContext;

abstract class WebBase
{
    protected $controllerName = '';
    protected $actionName = '';

    abstract public function before(WebContext $context);

    abstract public function after(WebContext $context);

    public function __construct($controllerName, $actionName)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }
}