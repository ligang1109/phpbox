<?php
/**
 * @file WriterInterface.php
 * @author ligang
 * @version 1.0
 * @date 2015-08-04
 */

namespace Phpbox\Log\Writer;

/**
 * Log writer interface
 */
interface WriterInterface
{/*{{{*/

    /**
        * Write log
        *
        * @param $message
        *
        * @return 
     */
    public function write($message);
}/*}}}*/
