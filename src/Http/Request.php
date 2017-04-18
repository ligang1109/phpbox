<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/19
 * Time: 18:21
 */

namespace Phpbox\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    protected $requestTarget = null;
    protected $method        = '';

    /**
     * @var UriInterface
     */
    protected $uri = null;


    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
        if (!is_null($this->requestTarget)) {
            return $this->requestTarget;
        }

        if (is_null($this->uri)) {
            return '/';
        }

        $target = $this->uri->getPath();
        if ($target == '') {
            $target = '/';
        }

        $query = $this->uri->getQuery();
        if ($query != '') {
            $target .= '?' . $query;
        }

        return $target;
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.

        $this->requestTarget = $requestTarget;

        return $this;
    }

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
        return $this->method;
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
        $this->method = strtoupper($method);

        return $this;
    }

    public function getUri()
    {
        // TODO: Implement getUri() method.
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
        $this->uri = $uri;
        if (!$preserveHost) {
            $this->updateHostByUri();
        }

        return $this;
    }


    private function updateHostByUri()
    {
        $host = $this->uri->getHost();
        if ($host == '') {
            return;
        }

        $port = $this->uri->getPort();
        if (!is_null($port)) {
            $host .= ':' . $port;
        }

        $this->withHeader('Host', $host);
    }
}