<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/23
 * Time: 21:08
 */

namespace Phpbox\Http;

use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function messageProvider()
    {
        $message = new Message();

        return array(
            array($message),
        );
    }

    /**
     * @dataProvider messageProvider
     * @param $message Message
     */
    public function testVersion($message)
    {
        $message->withProtocolVersion('1.1');

        $this->assertEquals($message->getProtocolVersion(), '1.1');
    }

    /**
     * @dataProvider messageProvider
     * @param $message Message
     */
    public function testHeader($message)
    {
        $message->withHeader('X-FORWARD-FOR', array('message', 'request'));
        $message->withAddedHeader('X-FORWARD-FOR', array('response', 'stream'));

        $values = $message->getHeader('X-forWard-fOR');
        $this->assertEquals(count($values), 4);
        $this->assertEquals($message->hasHeader('x-fORwARD-for'), true);
        $this->assertEquals($message->getHeaderLine('x-fORwARD-for'), 'message,request,response,stream');

        $message->withoutHeader('x-FORward-For');
        $values = $message->getHeader('x-forward-for');
        $this->assertEquals(empty($values), true);
        $this->assertEquals($message->hasHeader('X-FORwaRD-For'), false);
    }

    /**
     * @dataProvider messageProvider
     * @param $message Message
     */
    public function testBody($message)
    {
        $fp = fopen('php://temp', 'r+');
        fwrite($fp, 'hello, stream');

        $body = new Stream($fp);
        $body->seek(0);

        $message->withBody($body);
        $body = $message->getBody();

        $this->assertEquals($body->getContents(), 'hello, stream');
    }
}