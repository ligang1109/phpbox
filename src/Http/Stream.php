<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/21
 * Time: 15:10
 */

namespace Phpbox\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const MODE_READ       = 0b01;
    const MODE_WRITE      = 0b10;
    const MODE_READ_WRITE = 0b11;


    private $stream   = null;
    private $size     = null;
    private $seekable = false;
    private $readable = false;
    private $writable = false;
    private $metaData = array();

    private static $readWriteModeConf = array(
        'r' => self::MODE_READ,
        'w+' => self::MODE_READ_WRITE,
        'r+' => self::MODE_READ_WRITE,
        'x+' => self::MODE_READ_WRITE,
        'c+' => self::MODE_READ_WRITE,
        'rb' => self::MODE_READ,
        'w+b' => self::MODE_READ_WRITE,
        'r+b' => self::MODE_READ_WRITE,
        'x+b' => self::MODE_READ_WRITE,
        'c+b' => self::MODE_READ_WRITE,
        'rt' => self::MODE_READ,
        'w+t' => self::MODE_READ_WRITE,
        'r+t' => self::MODE_READ_WRITE,
        'x+t' => self::MODE_READ_WRITE,
        'c+t' => self::MODE_READ_WRITE,
        'a+' => self::MODE_READ_WRITE,
        'w' => self::MODE_WRITE,
        'rw' => self::MODE_WRITE,
        'wb' => self::MODE_WRITE,
        'a' => self::MODE_WRITE,
    );


    public function __construct($stream)
    {
        if (!is_resource($stream)) {
            throw new \InvalidArgumentException('Stream must be a resource');
        }
        $this->stream = $stream;

        $this->metaData = stream_get_meta_data($this->stream);
        $this->updateSize();
        $this->seekable = $this->metaData['seekable'];

        $mode = self::$readWriteModeConf[$this->metaData['mode']];
        if ($mode & self::MODE_READ) {
            $this->readable = true;
        }
        if ($mode & self::MODE_WRITE) {
            $this->writable = true;
        }
    }

    public function __toString()
    {
        try {
            $this->seek(0);
            return (string)$this->getContents();
        } catch (\Exception $e) {
            return '';
        }
    }

    public function close()
    {
        // TODO: Implement close() method.
        if (is_null($this->stream)) {
            return;
        }

        fclose($this->stream);
        $this->detach();
    }

    public function detach()
    {
        // TODO: Implement detach() method.
        if (is_null($this->stream)) {
            return null;
        }

        $result = $this->stream;

        $this->stream   = $this->size = null;
        $this->seekable = $this->readable = $this->writable = false;

        return $result;
    }

    public function getSize()
    {
        // TODO: Implement getSize() method.
        return $this->size;
    }

    public function tell()
    {
        // TODO: Implement tell() method.
        $result = ftell($this->stream);
        if ($result === false) {
            throw new \RuntimeException('Unable to determine stream position');
        }

        return $result;
    }

    public function eof()
    {
        // TODO: Implement eof() method.
        return feof($this->stream);
    }

    public function isSeekable()
    {
        // TODO: Implement isSeekable() method.
        return $this->seekable;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
        if (!$this->seekable) {
            throw new \RuntimeException('Stream is not seekable');
        }

        if (fseek($this->stream, $offset, $whence) === -1) {
            throw new \RuntimeException('Stream can not seek to ' . $offset . 'from whence' . $whence);
        }
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
        $this->seek(0);
    }

    public function isWritable()
    {
        // TODO: Implement isWritable() method.
        return $this->writable;
    }

    public function write($string)
    {
        // TODO: Implement write() method.
        if (!$this->writable) {
            throw new \RuntimeException('Cannot write to a non-writable stream');
        }

        $n = fwrite($this->stream, $string);
        if ($n === false) {
            throw new \RuntimeException('Unable to write to stream');
        }

        $this->updateSize();

        return $n;
    }

    public function isReadable()
    {
        // TODO: Implement isReadable() method.
        return $this->readable;
    }

    public function read($length)
    {
        // TODO: Implement read() method.
        if (!$this->readable) {
            throw new \RuntimeException('Cannot read from non-readable stream');
        }

        $str = fread($this->stream, $length);
        if ($str === false) {
            throw new \RuntimeException('Unable to read from stream');
        }

        return $str;
    }

    public function getContents()
    {
        // TODO: Implement getContents() method.
        $contents = stream_get_contents($this->stream);
        if ($contents === false) {
            throw new \RuntimeException('Unable to get stream contents');
        }

        return $contents;
    }

    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
        if (is_null($key)) {
            return $this->metaData;
        }

        return isset($this->metaData[$key]) ? $this->metaData[$key] : null;
    }


    private function updateSize()
    {
        if (isset($this->metaData['uri'])) {
            clearstatcache(true, $this->metaData['uri']);
        }

        $st = fstat($this->stream);
        if (isset($st['size'])) {
            $this->size = $st['size'];
        }
    }
}