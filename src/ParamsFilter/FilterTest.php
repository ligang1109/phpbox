<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 11:14
 */

namespace Phpbox\ParamsFilter;

use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    public function testRun()
    {
        $processor = new GeneralProcessor();
        $checker = new GeneralChecker();
        $filter = new Filter();

        $filter->withParam('name',
                           '',
                           array($processor, 'processStr'),
                           array($checker, 'checkStrNotNull'),
                           '姓名不能为空')
            ->withParam('sex',
                        '0',
                        array($processor, 'processInt'),
                        array($checker, 'checkIntNotZero'),
                        '性别错误')
            ->withParam('title',
                        null,
                        array($processor, 'processStr'),
                        array($checker, 'checkStrNotNull'),
                        '标题不正确');

        $params = array(
            'name' => ' 张三 ',
            'sex' => 0,
        );
        $result = $filter->run($params);
        $params = $result->getParams();
        $errors = $result->getErrors();

        $this->assertEquals($result->hasError(), true);
        $this->assertEquals($params['name'], '张三');
        $this->assertEquals($params['sex'], 0);
        $this->assertEquals(isset($params['title']), false);
        $this->assertEquals($errors['sex'], '性别错误');
    }
}