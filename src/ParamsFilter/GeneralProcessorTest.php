<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 10:44
 */

namespace Phpbox\ParamsFilter;

use PHPUnit\Framework\TestCase;

class GeneralProcessorTest extends TestCase
{
    public function testStr()
    {
        $processor = new GeneralProcessor();
        $value = $processor->processStr(' abc ');

        $this->assertEquals($value, 'abc');
    }

    public function testInt()
    {
        $processor = new GeneralProcessor();
        $value = $processor->processInt(' 123 ');

        $this->assertEquals($value, 123);
    }

    public function testFloat()
    {
        $processor = new GeneralProcessor();
        $value = $processor->processFloat(' 123.223 ');

        $this->assertEquals($value, 123.223);
    }

    public function testArr()
    {
        $processor = new GeneralProcessor();
        $value = array(
            'name' => ' abc ',
            'value' => array(
                'name' => ' next abc ',
                'value' => ' hahaha ',
            ),
        );

        $value = $processor->processArr($value);
        $this->assertEquals($value['name'], 'abc');
        $this->assertEquals($value['value']['name'], 'next abc');
        $this->assertEquals($value['value']['value'], 'hahaha');
    }
}