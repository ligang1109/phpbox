<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 9:51
 */

namespace Phpbox\ParamsFilter;

use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testParams()
    {
        $result = new Result();
        $result->withParam('name', 'phpbox')
               ->withParam('desc', 'my php frame');

        $params = $result->getParams();
        $this->assertEquals($params['name'], 'phpbox');
        $this->assertEquals($params['desc'], 'my php frame');
    }

    public function testErrors()
    {
        $result = new Result();
        $result->withError('name')
               ->withError('desc', '描述不能为空');

        $errors = $result->getErrors();
        $this->assertEquals($errors['name'], '');
        $this->assertEquals($errors['desc'], '描述不能为空');
    }
}