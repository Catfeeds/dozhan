<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * HTTP 设计了很多动词，来表示不同的操作，RESTful 很好的利用的这一点，我们需要正确的使用 HTTP 动词，来表明我们要如何操作资源。
 * 先来解释一个概念，幂等性，指一次和多次请求某一个资源应该具有同样的副作用，也就是一次访问与多次访问，对这个资源带来的变化是相同的。
 */

/*
 *   动词	    描述	                                是否幂等
 *
 *   GET	    获取资源，单个或多个	                是
 *   POST	    创建资源	                            否
 *   PUT	    更新资源，客户端提供完整的资源数据	    是
 *   PATCH	    更新资源，客户端提供部分的资源数据	    否
 *   DELETE	    删除资源                             是
 */

// Dingo/api 路由 获得一个路由实例
$api = app(\Dingo\Api\Routing\Router::class);

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer',
],function ($api){
    //游客可以访问的接口
    $api->group([
        'middleware' => 'api.throttle', //DingoApi 已经为我们提供了调用频率限制的中间件 api.throttle
        'limit' => config('api.rate_limits.sign.limit'),    //接口频率限制
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        //测试接口
        $api->get('test','TestController@store')->name('api.test.store');
        //邮箱验证码
        $api->post('verificationCodes/email','VerificationCodesController@email')->name('api.verificationCodes.email');
        //用户注册
        $api->post('user','UserController@store')->name('api.users.store');
        //用户登陆
        $api->post('authorizations','AuthorizationsController@store')->name('api.authorizations.store');
    });

    //需要token验证的接口
    $api->group(['middleware' => 'api.auth'],function ($api){
        //刷新token
        $api->put('authorizations/current','AuthorizationsController@update')->name('api.authorizations.update');
        //删除token
        $api->delete('authorizations/current','AuthorizationsController@destroy')->name('api.authorizations.destroy');
        //当前登陆用户信息
        $api->get('user','UserController@me')->name('api.user.show');
        //编辑登陆用户信息 patch 部分修改资源，提供部分资源信息 注意，PATCH 请求方式只能接收 application/x-www-form-urlencoded 的 [Content-type] 的表单信息
        $api->patch('user','UserController@update')->name('api.user.update');
        //资源api
        $api->group(['prefix' => 'resource'],function ($api){
            $api->post('image','ResourceController@image')->name('api.resource.image');
        });
    });

});
