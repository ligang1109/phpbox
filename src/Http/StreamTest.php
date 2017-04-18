<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/21
 * Time: 18:20
 */

namespace Phpbox\Http;

use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    public function streamProvider()
    {
        $fp = fopen('php://temp', 'r+');
        fwrite($fp, 'hello, stream');

        $stream = new Stream($fp);
        $stream->seek(0);

        return array(
            array($stream),
        );
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testToString($stream)
    {
        $this->assertEquals("$stream", 'hello, stream');
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testClose($stream)
    {
        $stream->close();

        $this->assertEquals($stream->getSize(), null);
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testGetSize($stream)
    {
        $this->assertEquals($stream->getSize(), strlen('hello, stream'));
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testSeekableReadableWriteable($stream)
    {
        $this->assertEquals($stream->isSeekable(), true);
        $this->assertEquals($stream->isReadable(), true);
        $this->assertEquals($stream->isWritable(), true);

        $stream->close();

        $this->assertEquals($stream->isSeekable(), false);
        $this->assertEquals($stream->isReadable(), false);
        $this->assertEquals($stream->isWritable(), false);
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testSeekRewindTell($stream)
    {
        $this->assertEquals($stream->tell(), 0);

        $stream->seek(5);
        $this->assertEquals($stream->tell(), 5);

        $stream->rewind();
        $this->assertEquals($stream->tell(), 0);
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testReadEof($stream)
    {
        $stream->seek(0, SEEK_END);
        $stream->read(1);
        $this->assertEquals($stream->eof(), true);
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testWrite($stream)
    {
        $stream->seek(0, SEEK_END);
        $n = $stream->write("\nhello, world");
        $this->assertEquals($n, strlen("\nhello, world"));
        $this->assertEquals($stream->getSize(), strlen("hello, stream\nhello, world"));
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testGetContents($stream)
    {
        $this->assertEquals($stream->getContents(), 'hello, stream');
    }

    /**
     * @dataProvider streamProvider
     * @param $stream Stream
     */
    public function testGetMetadata($stream)
    {
        $this->assertEquals($stream->getMetadata('uri'), 'php://temp');
    }
}