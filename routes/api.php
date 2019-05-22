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

Route::middleware('auth:api')->get('/user', function (Request $request){
    return $request->user();
});
Route::any('UserApi/{method}','Api\UserApiController@method');//用户信息
Route::any('QRCode/{method}','Wx\QRCodeController@method');//二维码接口
Route::any('message/{method}','Wx\MessagePushController@method');//信息发送接口
Route::any('userInfo/{method}','Wx\UserController@method');//用户微信个人信息接口
Route::any('orderControl/{method}','Api\OrderApiController@method');//订单信息
