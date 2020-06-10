<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addGroup('/api/', function () {
    /**
     * 测试用户组
     */
    Router::addGroup('test/', function () {
        //列表
        Router::get('index', 'App\Controller\Test\IndexController@index');
        //添加
        Router::post('store', 'App\Controller\Test\IndexController@store');
        //获取详情
        Router::get('show/{id}', 'App\Controller\Test\IndexController@show');
        //修改
        Router::put('update/{id}', 'App\Controller\Test\IndexController@update');
        //移除
        Router::delete('destroy/{id}', 'App\Controller\Test\IndexController@destroy');
        //GRpc
        Router::get('gRpc', 'App\Controller\Test\GRpcController@index');
    });
});

/**
 * gRpc服务
 */
Router::addServer('grpc', function () {
    Router::addGroup('/rpc/', function () {
        Router::addGroup('test/', function () {
            Router::post('test', 'App\Controller\Rpc\IndexController@test');
        });
    });
});

/**
 * 首页
 */
Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\Web\IndexController@index');
/**
 * 查看错误报警
 */
Router::addRoute(['GET', 'POST'], '/error/{id}', 'App\Controller\Test\CommonController@error');
