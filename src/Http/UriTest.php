<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/20
 * Time: 18:10
 */

namespace Phpbox\Http;

use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{
    public function testConstruct()
    {
        $uri = new Uri('http://ligang:123@www.phpbox.com:8080/uri/test?a=1&b=c中文#demo测试');

        $this->assert($uri);
    }

    public function testWith()
    {
        $uri = new Uri();

        $uri->withScheme('http')
            ->withUserInfo('ligang:123')
            ->withHost('www.phpbox.com')
            ->withPort(8080)
            ->withPath('/uri/test')
            ->withQuery('a=1&b=c中文')
            ->withFragment('demo测试');

        $this->assert($uri);
    }

    /**
     * @param $uri Uri
     */
    private function assert($uri)
    {
        $this->assertEquals('http', $uri->getScheme());
        $this->assertEquals('ligang:123@www.phpbox.com:8080', $uri->getAuthority());
        $this->assertEquals('ligang:123', $uri->getUserInfo());
        $this->assertEquals('www.phpbox.com', $uri->getHost());
        $this->assertEquals(8080, $uri->getPort());
        $this->assertEquals('/uri/test', $uri->getPath());
        $this->assertEquals('a=1&b=' . rawurlencode('c中文'), $uri->getQuery());
        $this->assertEquals(rawurlencode('demo测试'), $uri->getFragment());
    }
}