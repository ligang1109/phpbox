<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/4/19
 * Time: 11:44
 */

namespace Phpbox\Core;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testFindRoute()
    {
        $router = new Router();

        $router->addRoute('#^/l/([0-9]+)$#', 'video', 'play')
               ->setDefaultRoute('tv', 'show');

        $path  = '/l/123456';
        $route = $router->findRoute($path);

        $this->assertEquals('video', $route['controllerName']);
        $this->assertEquals('play', $route['actionName']);

        $path  = '/demo/abc';
        $route = $router->findRoute($path);

        $this->assertEquals('demo', $route['controllerName']);
        $this->assertEquals('abc', $route['actionName']);

        $path  = '';
        $route = $router->findRoute($path);

        $this->assertEquals('tv', $route['controllerName']);
        $this->assertEquals('show', $route['actionName']);

        $path  = '/abc';
        $route = $router->findRoute($path);

        $this->assertEquals('abc', $route['controllerName']);
        $this->assertEquals('show', $route['actionName']);
    }
}