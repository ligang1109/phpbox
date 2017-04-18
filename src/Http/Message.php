<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/21
 * Time: 9:55
 */

namespace Phpbox\Http;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{
    protected $protocolVersion = 'HTTP/1.1';
    protected $body            = null;

    /**
     * @var array strtolower($originName) => array('originName' => $originName, 'values' => array())
     */
    protected $headers = array();


    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.

        return $this->protocolVersion;
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.

        $this->protocolVersion = $version;
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
        $headers = array();
        foreach ($this->headers as $item) {
            $headers[$item['origin_name']] = $item['values'];
        }

        return $headers;
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
        return isset($this->headers[$this->toHeaderKey($name)]) ? true : false;
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
        $key = $this->toHeaderKey($name);

        return isset($this->headers[$key]) ? $this->headers[$key]['values'] : array();
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
        $values = $this->getHeader($name);

        return empty($values) ? '' : implode(',', $values);
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
        $key    = $this->toHeaderKey($name);
        $values = is_array($value) ? $value : array($value);
        $values = $this->trimHeaderValues($values);

        $this->headers[$key] = array(
            'origin_name' => $name,
            'values' => $values,
        );

        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
        $key    = $this->toHeaderKey($name);
        $values = is_array($value) ? $value : array($value);
        $values = $this->trimHeaderValues($values);

        if (isset($this->headers[$key])) {
            $this->headers[$key]['values'] = array_merge($this->headers[$key]['values'], $values);
        } else {
            $this->headers[$key] = array(
                'origin_name' => $name,
                'values' => $values,
            );
        }

        return $this;
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
        $key = $this->toHeaderKey($name);
        if (isset($this->headers[$key])) {
            unset($this->headers[$key]);
        }

        return $this;
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
        $this->body = $body;

        return $this;
    }


    private function toHeaderKey($name)
    {
        return strtolower($name);
    }

    private function trimHeaderValues(array $values)
    {
        return array_map(
            array($this, 'trimHeaderValue'),
            $values
        );
    }

    private function trimHeaderValue($value)
    {
        return trim($value, " \t");
    }
}