<?php

namespace Phpbox\Core\System;

use Phpbox\Core\Action\Web404NotFoundBase;
use Phpbox\Http\ServerRequest;
use Phpbox\Http\Response;
use Phpbox\Http\Stream;
use Phpbox\Core\WebContext;
use Phpbox\Core\Action\WebBase;
use Phpbox\Core\Action\WebErrorBase;

/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/18
 * Time: 13:08
 */
class Web extends Base
{
    private $serverRequest = null;
    private $response      = null;
    private $context       = null;

    public function __construct($prjName, $sysName)
    {
        parent::__construct($prjName, $sysName);

        $this->serverRequest = ServerRequest::createByServerValues();
        $this->response      = new Response();
        $this->context       = new WebContext($this->serverRequest, $this->response);
    }

    public function getServerRequest()
    {
        return $this->serverRequest;
    }

    public function run()
    {
        $path  = $this->serverRequest->getUri()->getPath();
        $route = $this->router->findRoute($path);

        $this->dispatch($route['controllerName'], $route['actionName'], $route['actionArgs']);

        $this->sendResponse();
    }


    private function dispatch($controllerName, $actionName, $actionArgs)
    {
        $action = $this->getAction($controllerName, $actionName);
        if (is_null($action)) {
            $this->process404NotFound();
            return;
        }

        if (!($action instanceof WebBase)) {
            throw new \RuntimeException(get_class($action) . ' must be instance of WebBase');
        }

        try {
            $action->before($this->context);
            if ($this->context->getData('endDispath')) {
                return;
            }
            call_user_func_array(array($action, 'run'), array($this->context) + $actionArgs);
            $action->after($this->context);
        } catch (\Exception $e) {
            if (!class_exists($this->errorActionClsname)) {
                throw $e;
            }

            $action = new $this->errorActionClsname();
            if (!($action instanceof WebErrorBase)) {
                throw new \RuntimeException(get_class($action) . ' must be instance of WebErrorBase');
            }
            $action->run($this->context, $e);
        }
    }

    private function process404NotFound()
    {
        if (class_exists($this->notFoundActionClsname)) {
            $action = new $this->notFoundActionClsname();
            if (!($action instanceof Web404NotFoundBase)) {
                throw new \RuntimeException(get_class($action) . ' must be instance of Web404NotFoundBase');
            }

            $action->run($this->context);
            return;
        }

        $fp   = fopen('php://temp', 'r+');
        $body = new Stream($fp);
        $body->write('404 Not Found');

        $this->context->getResponse()->withStatus(404)->withBody($body);
    }

    private function sendResponse()
    {
        $statusCode = $this->response->getStatusCode();
        if ($statusCode) {
            header($this->response->getProtocolVersion() . ' ' . $statusCode . ' ' . $this->response->getReasonPhrase());
        }

        foreach ($this->response->getHeaders() as $name => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            header($name . ': ' . $value);
        }

        echo $this->response->getBody();
    }
}