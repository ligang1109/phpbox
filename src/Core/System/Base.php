<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/19
 * Time: 14:34
 */

namespace Phpbox\Core\System;

use Phpbox\Core\Router;

abstract class Base
{
    abstract public function run();

    protected $prjName = '';
    protected $sysName = '';
    protected $router  = null;

    protected $notFoundActionClsname = '';
    protected $errorActionClsname = '';

    public function __construct($prjName, $sysName)
    {
        $this->prjName = ucfirst($prjName);
        $this->sysName = ucfirst($sysName);
        $this->router = new Router();
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setNotFoundActionClsname($notFoundActionClsname)
    {
        $this->notFoundActionClsname = $notFoundActionClsname;

        return $this;
    }

    public function setErrorActionClsname($errorActionClsname)
    {
        $this->errorActionClsname = $errorActionClsname;

        return $this;
    }


    protected function getAction($controllerName, $actionName)
    {
        $controllerName = ucfirst($controllerName);
        $actionName = ucfirst($actionName);
        $actionClsname = '\\' . $this->prjName
                         . '\\System'
                         . '\\' . $this->sysName
                         . '\\Action'
                         . '\\' . $controllerName
                         . '\\' . $actionName;

        if (class_exists($actionClsname)) {
            return new $actionClsname($controllerName, $actionName);
        }

        return null;
    }
}