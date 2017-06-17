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
        $value     = $processor->processStr(' abc ');

        $this->assertEquals($value, 'abc');
    }

    public function testInt()
    {
        $processor = new GeneralProcessor();
        $value     = $processor->processInt(' 123 ');

        $this->assertEquals($value, 123);
    }

    public function testFloat()
    {
        $processor = new GeneralProcessor();
        $value     = $processor->processFloat(' 123.223 ');

        $this->assertEquals($value, 123.223);
    }

    public function testArr()
    {
        $processor = new GeneralProcessor();

        $value = $processor->processArr($this->getArrTestValue());
        $this->assertEquals($value['name'], 'abc');
        $this->assertEquals($value['value']['name'], 'next abc');
        $this->assertEquals($value['value']['value'], 'hahaha');

        $checker     = new GeneralChecker();
        $valueFilter = new Filter();
        $valueFilter->withParam('name',
                                '',
                                array($processor, 'processStr'),
                                array($checker, 'checkStrNotNull'),
                                '姓名不能为空')
                    ->withParam('value',
                                '',
                                array($processor, 'processStr'),
                                array($checker, 'checkStrNotNull'),
                                '值不能为空');

        $filter = new Filter();
        $filter->withParam('name',
                           '',
                           array($processor, 'processStr'),
                           array($checker, 'checkStrNotNull'),
                           '姓名不能为空')
               ->withParam('value',
                           array(),
                           array($processor, 'processArr'),
                           null,
                           '',
                           true,
                           array($valueFilter));

        $result = $processor->processArr($this->getArrTestValue(), $filter);
        $value = $result->getParams();

        $this->assertEquals($value['name'], 'abc');
        $this->assertEquals($value['value']['name'], 'next abc');
        $this->assertEquals($value['value']['value'], 'hahaha');
    }

    private function getArrTestValue()
    {
        return array(
            'name'  => ' abc ',
            'value' => array(
                'name'  => ' next abc ',
                'value' => ' hahaha ',
            ),
        );
    }
}