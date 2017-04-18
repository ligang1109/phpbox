<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/25
 * Time: 14:43
 */

namespace Phpbox\Http;

use PHPUnit\Framework\TestCase;

class UploadedFileTest extends TestCase
{
    public function uploadedFileProvider()
    {
        $fp = fopen('/tmp/test_uploaded_file_stream.txt', 'c+');
        fwrite($fp, 'hello, world');
        $stream = new Stream($fp);
        $stream->rewind();
        $uf = new UploadedFile($stream, 'hello.txt', 'application/octet-stream', UPLOAD_ERR_OK, 12);

        return array(
            array($uf),
        );
    }

    /**
     * @dataProvider uploadedFileProvider
     * @param $uploadedFile UploadedFile
     */
    public function testGetStream($uploadedFile)
    {
        $stream = $uploadedFile->getStream();

        $this->assertEquals($stream->getContents(), 'hello, world');
    }

    /**
     * @dataProvider uploadedFileProvider
     * @param $uploadedFile UploadedFile
     */
    public function testMoveTo($uploadedFile)
    {
        $targetPath = '/tmp/test_uploaded_file.txt';
        if (file_exists($targetPath)) {
            unlink($targetPath);
        }

        $uploadedFile->moveTo($targetPath);

        $this->assertEquals(file_exists($targetPath), true);
    }

    /**
     * @dataProvider uploadedFileProvider
     * @param $uploadedFile UploadedFile
     */
    public function testGetSize($uploadedFile)
    {
        $this->assertEquals($uploadedFile->getSize(), strlen('hello, world'));
    }

    /**
     * @dataProvider uploadedFileProvider
     * @param $uploadedFile UploadedFile
     */
    public function testGetError($uploadedFile)
    {
        $this->assertEquals($uploadedFile->getError(), UPLOAD_ERR_OK);
    }

    /**
     * @dataProvider uploadedFileProvider
     * @param $uploadedFile UploadedFile
     */
    public function testGetClientFilename($uploadedFile)
    {
        $this->assertEquals($uploadedFile->getClientFilename(), 'hello.txt');
    }

    /**
     * @dataProvider uploadedFileProvider
     * @param $uploadedFile UploadedFile
     */
    public function testGetClientMediaType($uploadedFile)
    {
        $this->assertEquals($uploadedFile->getClientMediaType(), 'application/octet-stream');
    }
}