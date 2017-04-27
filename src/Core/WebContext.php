<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/28
 * Time: 17:29
 */

namespace Phpbox\Core;

use Phpbox\Http\ServerRequest;
use Phpbox\Http\Response;

class WebContext extends Context
{
    private $request  = null;
    private $response = null;

    public function __construct(ServerRequest $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}