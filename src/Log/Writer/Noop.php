<?php
/**
 * @file Noop.php
 * @author ligang
 * @version 1.0
 * @date 2015-08-04
 */

namespace Phpbox\Log\Writer;

/**
 * Nothing to do
 */
class Noop implements WriterInterface
{

    /**
     * {@inheritdoc}
     */
    public function write($message)
    {
    }
}
