<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 9:14
 */

namespace Phpbox\ParamsFilter;


class Result
{
    private $params = array();
    private $errors = array();

    public function hasError()
    {
        return !empty($this->errors) ? true : false;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function withParam($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    public function withError($name, $msg = '')
    {
        $this->errors[$name] = $msg;

        return $this;
    }
}