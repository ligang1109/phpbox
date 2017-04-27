<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/4
 * Time: 10:12
 */

namespace Phpbox\Core\Action;

use Phpbox\Core\Context;

abstract class Base
{
    protected $controllerName = '';
    protected $actionName = '';

    abstract public function before(Context $context);

    abstract public function after(Context $context);

    public function __construct($controllerName, $actionName)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }
}