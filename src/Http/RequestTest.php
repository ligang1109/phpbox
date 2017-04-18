<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/24
 * Time: 15:27
 */

namespace Phpbox\Http;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function requestProvider()
    {
        $request = new Request();

        return array(
            array($request),
        );
    }

    /**
     * @dataProvider requestProvider
     * @param $request Request
     */
    public function testRequestTarget($request)
    {
        $request->withRequestTarget('/pbox/request?a=1&b=2');

        $this->assertEquals($request->getRequestTarget(), '/pbox/request?a=1&b=2');
    }

    /**
     * @dataProvider requestProvider
     * @param $request Request
     */
    public function testMethod($request)
    {
        $request->withMethod('get');

        $this->assertEquals($request->getMethod(), 'GET');
    }

    /**
     * @dataProvider requestProvider
     * @param $request Request
     */
    public function testUri($request)
    {
        $uri = new Uri('http://ligang:123@www.phpbox.com:8080/uri/test?a=1&b=c中文#demo测试');
        $request->withUri($uri);

        $uri = $request->getUri();
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals('ligang:123@www.phpbox.com:8080', $uri->getAuthority());
        $this->assertEquals('ligang:123', $uri->getUserInfo());
        $this->assertEquals('www.phpbox.com', $uri->getHost());
        $this->assertEquals(8080, $uri->getPort());
        $this->assertEquals('/uri/test', $uri->getPath());
        $this->assertEquals('a=1&b=' . rawurlencode('c中文'), $uri->getQuery());
        $this->assertEquals(rawurlencode('demo测试'), $uri->getFragment());

        $uri = new Uri('http://ligang:123@www.pbox.com:8081/uri/test?a=1&b=c中文#demo测试');
        $request->withUri($uri);
        $host = $request->getHeader('host');
        $this->assertEquals($host[0], 'www.pbox.com:8081');
    }
}