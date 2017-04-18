<?php

namespace Phpbox\Core\System;

use Phpbox\Http\ServerRequest;
use Phpbox\View\ViewInterface;

/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/18
 * Time: 13:08
 */
class Web extends Base
{
    private $serverRequest = null;
    private $view = null;

    public function __construct($sysName)
    {
        parent::__construct($sysName);

        $this->serverRequest = ServerRequest::createByServerValues();
    }

    public function getServerRequest()
    {
        return $this->serverRequest;
    }

    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }

    public function run()
    {

    }
}