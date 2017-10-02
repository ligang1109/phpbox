<?php
/**
 * @file Noop.php
 * @author ligang
 * @version 1.0
 * @date 2015-08-04
 */

namespace Phpbox\Log\Formater;

class Noop implements FormaterInterface
{

    /**
     * {@inheritdoc}
     */
    public function fmt($level, $message, array $context = array())
    {
        return $message;
    }
}
