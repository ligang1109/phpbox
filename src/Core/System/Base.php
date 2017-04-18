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

    protected $sysName = '';
    protected $router  = null;


    public function __construct($sysName)
    {
        $this->sysName = ucfirst($sysName);
        $this->router = new Router();
    }

    public function getRouter()
    {
        return $this->router;
    }
}