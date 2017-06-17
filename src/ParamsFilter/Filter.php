<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/5/9
 * Time: 8:57
 */

namespace Phpbox\ParamsFilter;


class Filter
{
    private $paramsConf = array();

    public function withParam($name,
                              $default = null,
                              $processFunc = null,
                              $checkFunc = null,
                              $errMsg = '',
                              $filterNull = true,
                              $processFuncArgs = array(),
                              $checkFuncArgs = array())
    {
        if (!is_null($processFunc)) {
            if (!is_callable($processFunc)) {
                throw new \InvalidArgumentException('processFunc must be callable');
            }
        }
        if (!is_null($checkFunc)) {
            if (!is_callable($checkFunc)) {
                throw new \InvalidArgumentException('checkFunc must be callable');
            }
        }

        $this->paramsConf[$name] = array(
            'default'         => $default,
            'processFunc'     => $processFunc,
            'checkFunc'       => $checkFunc,
            'errMsg'          => $errMsg,
            'filterNull'      => $filterNull,
            'processFuncArgs' => $processFuncArgs,
            'checkFuncArgs'   => $checkFuncArgs,
        );

        return $this;
    }

    /**
     * @param array $params
     * @return Result
     */
    public function run(array $params)
    {
        $result = new Result();
        foreach ($this->paramsConf as $name => $conf) {
            $value = isset($params[$name]) ? $params[$name] : $conf['default'];
            if (is_null($value)) {
                if ($conf['filterNull']) {
                    continue;
                }
            }

            if (!is_null($conf['processFunc'])) {
                $value = call_user_func_array($conf['processFunc'], array_merge(array($value), $conf['processFuncArgs']));
            }

            if ($value instanceof Result) {
                $result->withParam($name, $value->getParams());
                if ($value->hasError()) {
                    $result->withError($name, $value->getErrors());
                }
            } else {
                $result->withParam($name, $value);
                if (!is_null($conf['checkFunc'])) {
                    $valid = call_user_func_array($conf['checkFunc'], array_merge(array($value), $conf['checkFuncArgs']));
                    if (!$valid) {
                        $result->withError($name, $conf['errMsg']);
                    }
                }
            }
        }

        return $result;
    }
}