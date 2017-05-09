<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 11:05
 */

namespace Phpbox\ParamsFilter;

use PHPUnit\Framework\TestCase;

class GeneralCheckerTest extends TestCase
{
    public function testStrNotNull()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkStrNotNull('abc'), true);
        $this->assertEquals($checker->checkStrNotNull(''), false);
    }

    public function testIntNotZero()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkIntNotZero(123), true);
        $this->assertEquals($checker->checkIntNotZero(0), false);
    }

    public function testFloatNotZero()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkFloatNotZero(123.223), true);
        $this->assertEquals($checker->checkFloatNotZero(0.0), false);
    }

    public function testArrNotEmpty()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkArrNotEmpty(array(1,2,3)), true);
        $this->assertEquals($checker->checkArrNotEmpty(array()), false);
    }

    public function testIsMd5()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkIsMd5(md5('abc')), true);
        $this->assertEquals($checker->checkIsMd5('123hahahah'), false);
    }

    public function testIsNum()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkIsNum(123), true);
        $this->assertEquals($checker->checkIsNum(123.223), true);
        $this->assertEquals($checker->checkIsNum('abc'), false);
    }

    public function testValidDateFormat()
    {
        $checker = new GeneralChecker();

        $this->assertEquals($checker->checkValidDateFormat('2017-05-09 10:12:16'), true);
        $this->assertEquals($checker->checkValidDateFormat('201abc'), false);
    }
}