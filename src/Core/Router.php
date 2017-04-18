<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/19
 * Time: 10:57
 */

namespace Phpbox\Core;

class Router
{
    private $routeTable   = array();
    private $defaultRoute = array(
        'controllerName' => 'index',
        'actionName' => 'index',
    );

    public function addRoute($regex, $controllerName, $actionName)
    {
        $this->routeTable[] = array(
            'regex' => $regex,
            'controllerName' => $controllerName,
            'actionName' => $actionName,
        );

        return $this;
    }

    public function setDefaultRoute($controllerName, $actionName)
    {
        $this->defaultRoute = array(
            'controllerName' => $controllerName,
            'actionName' => $actionName,
        );

        return $this;
    }

    public function findRoute($path)
    {
        $path = trim(strtolower($path));

        $route = $this->findRouteByDefined($path);
        if (!empty($route)) {
            return $route;
        }

        return $this->findRouteByGeneral($path);
    }

    private function findRouteByDefined($path)
    {
        foreach ($this->routeTable as $item) {
            if (preg_match($item['regex'], $path, $matches)) {
                array_shift($matches);

                return array(
                    'controllerName' => $item['controllerName'],
                    'actionName' => $item['actionName'],
                    'actionArgs' => $matches,
                );
            }
        }

        return array();
    }

    private function findRouteByGeneral($path)
    {
        $pathData    = explode('/', trim($path, '/'));
        $pathData[0] = trim($pathData[0]);

        if ($pathData[0] == '') {
            $controllerName = $this->defaultRoute['controllerName'];
            $actionName     = $this->defaultRoute['actionName'];
        } else {
            $controllerName = $pathData[0];
            if (isset($pathData[1])) {
                $pathData[1] = trim($pathData[1]);
                if ($pathData[1] == '') {
                    $actionName = $this->defaultRoute['actionName'];
                } else {
                    $actionName = $pathData[1];
                }
            } else {
                $actionName = $this->defaultRoute['actionName'];
            }
        }

        return array(
            'controllerName' => $controllerName,
            'actionName' => $actionName,
            'actionArgs' => array(),
        );
    }
}