<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/24
 * Time: 15:57
 */

namespace Phpbox\Http;

use Psr\Http\Message\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    private $serverParams  = array();
    private $cookieParams  = array();
    private $queryParams   = array();
    private $uploadedFiles = array();
    private $parsedBody    = null;
    private $attributes    = array();


    public function __construct(array $serverParams)
    {
        $this->serverParams = $serverParams;
        foreach ($this->serverParams as $key => $value) {
            $this->withAttribute($key, $value);
        }

        $this->initBySuperValues();
    }

    public static function createByServerValues()
    {
        $serverRequest = new ServerRequest($_SERVER);

        $uri = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $uri .= $_SERVER['HTTP_HOST'] . $_SERVER['SERVER_PORT'];

        $serverRequest->withProtocolVersion($_SERVER['SERVER_PROTOCOL'])
                      ->withRequestTarget($_SERVER['REQUEST_URI'])
                      ->withMethod($_SERVER['REQUEST_METHOD'])
                      ->withUri(new Uri($uri));

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $name = str_replace('_', '-', substr($key, 5));
                $serverRequest->withHeader($name, $value);
            }
        }
    }

    public function getServerParams()
    {
        // TODO: Implement getServerParams() method.
        return $this->serverParams;
    }

    public function getCookieParams()
    {
        // TODO: Implement getCookieParams() method.
        return $this->cookieParams;
    }

    public function withCookieParams(array $cookies)
    {
        // TODO: Implement withCookieParams() method.
        $this->cookieParams = $cookies;

        return $this;
    }

    public function getQueryParams()
    {
        // TODO: Implement getQueryParams() method.
        return $this->queryParams;
    }

    public function withQueryParams(array $query)
    {
        // TODO: Implement withQueryParams() method.
        $this->queryParams = $query;

        return $this;
    }

    public function getUploadedFiles()
    {
        // TODO: Implement getUploadedFiles() method.
        return $this->uploadedFiles;
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        // TODO: Implement withUploadedFiles() method.
        $this->uploadedFiles = $uploadedFiles;
    }

    public function getParsedBody()
    {
        // TODO: Implement getParsedBody() method.
        return $this->parsedBody;
    }

    public function withParsedBody($data)
    {
        // TODO: Implement withParsedBody() method.
        $this->parsedBody = $data;

        return $this;
    }

    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
        return $this->attributes;
    }

    public function getAttribute($name, $default = null)
    {
        // TODO: Implement getAttribute() method.
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }

    public function withAttribute($name, $value)
    {
        // TODO: Implement withAttribute() method.
        $this->attributes[$name] = $value;

        return $this;
    }

    public function withoutAttribute($name)
    {
        // TODO: Implement withoutAttribute() method.
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }

        return $this;
    }


    private function initBySuperValues()
    {
        if (!empty($_COOKIE)) {
            $this->withCookieParams($_COOKIE);
        }
        if (!empty($_GET)) {
            $this->withQueryParams($_GET);
        }
        if (!empty($_POST)) {
            $this->withParsedBody($_POST);
        }
        if (!empty($_FILES)) {
            $uploadedFiles = array();
            foreach ($_FILES as $key => $item) {
                $fp                  = fopen($item['tmp_name'], 'r+');
                $stream              = new Stream($fp);
                $uploadedFiles[$key] = new UploadedFile($stream, $item['name'], $item['type'], $item['error'], $item['size']);
            }
        }
    }
}