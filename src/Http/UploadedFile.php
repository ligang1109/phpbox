<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/24
 * Time: 17:51
 */

namespace Phpbox\Http;

use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\StreamInterface;

class UploadedFile implements UploadedFileInterface
{
    private $clientFilename = '';
    private $mediaType      = '';
    private $error          = null;
    private $size           = 0;

    /**
     * @var StreamInterface
     */
    private $stream = null;

    private static $validErrors = array(
        UPLOAD_ERR_OK => 1,
        UPLOAD_ERR_INI_SIZE => 1,
        UPLOAD_ERR_FORM_SIZE => 1,
        UPLOAD_ERR_PARTIAL => 1,
        UPLOAD_ERR_NO_FILE => 1,
        UPLOAD_ERR_NO_TMP_DIR => 1,
        UPLOAD_ERR_CANT_WRITE => 1,
        UPLOAD_ERR_EXTENSION => 1,
    );


    public function __construct(StreamInterface $stream, $clientFilename, $mediaType, $error, $size)
    {
        if (!isset(self::$validErrors[$error])) {
            throw new \InvalidArgumentException('Invalid error');
        }

        $this->stream         = $stream;
        $this->clientFilename = $clientFilename;
        $this->mediaType      = $mediaType;
        $this->error          = $error;
        $this->size           = $size;
    }

    public function getStream()
    {
        // TODO: Implement getStream() method.
        return $this->stream;
    }

    public function moveTo($targetPath)
    {
        // TODO: Implement moveTo() method.
        $meta = $this->stream->getMetadata();
        if (is_uploaded_file($meta['uri'])) {
            move_uploaded_file($meta['uri'], $targetPath);
        } else {
            rename($meta['uri'], $targetPath);
        }
    }

    public function getSize()
    {
        // TODO: Implement getSize() method.
        return $this->size;
    }

    public function getError()
    {
        // TODO: Implement getError() method.
        return $this->error;
    }

    public function getClientFilename()
    {
        // TODO: Implement getClientFilename() method.
        return $this->clientFilename;
    }

    public function getClientMediaType()
    {
        // TODO: Implement getClientMediaType() method.
        return $this->mediaType;
    }
}