<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/26
 * Time: 9:45
 */

namespace Phpbox\Http;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function responseProvider()
    {
        $response = new Response();

        return array(
            array($response),
        );
    }

    /**
     * @dataProvider responseProvider
     * @param $response Response
     */
    public function testStatus($response)
    {
        $response->withStatus(200, 'Process OK');
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getReasonPhrase(), 'Process OK');

        $response->withStatus(404);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getReasonPhrase(), 'Not Found');

        $response->withStatus(520, 'test response status');
        $this->assertEquals($response->getStatusCode(), 520);
        $this->assertEquals($response->getReasonPhrase(), 'test response status');
    }
}