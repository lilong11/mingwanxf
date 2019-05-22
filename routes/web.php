<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    return view('welcome');
});

Route::group(['namespace'=>'Admin','prefix'=>'admin'],function (){
    Route::any('login',"LoginController@adminLogin");
    Route::any('doLogin',"LoginController@do_login");
    Route::any('loginOut',"LoginController@login_out");

    Route::group(['middleware'=>'loginCheck'],function (){
        Route::any('index', "IndexController@index");//后台首页
        Route::any('site', "SortsController@siteType");//场地类型管理页
        Route::any('siteStop/{id}', "SortsController@siteStop");//场地类型禁用
        Route::any('siteStart/{id}', "SortsController@siteStart");//场地类型启用
        Route::any('memberList', 'MemberController@memberList');//用户列表页
        Route::any('memberStop/{id}', 'MemberController@memberStop');//用户禁用
        Route::any('memberStart/{id}', 'MemberController@memberStart');//用户启用
        Route::any('memberOrder/{id}', 'MemberController@memberOrderList');//用户订单列表
        Route::any('memberEdit/{id}', 'MemberController@memberEdit');//用户编辑
        Route::any('wxUserList', 'MemberController@wxUserList');//微信用户信息列表
        Route::any('memberInvite/{id}', 'MemberController@memberInvite');//微信用户邀请
        Route::any('orderList', 'OrderController@orderList');//订单列表
        Route::any('orderDelete/{id}', 'OrderController@orderDelete');//订单取消
        Route::any('decorationEditPage/{id}', 'OrderController@decorationEditPage');//工程编辑页面
        Route::any('decorationEdit', 'OrderController@decorationEdit');//工程编辑功能
        Route::any('picUpload', 'OrderController@decorationPic');//上传图片功能
        Route::any('adminList', 'AdminMemberController@adminList');//职员列表
        Route::any('adminAdd', 'AdminMemberController@adminAdd');//职员添加
        Route::any('adminEditPage/{id}', 'AdminMemberController@adminEditPage');//职员编辑页面
        Route::any('adminEdit', 'AdminMemberController@adminEdit');//职员编辑功能
        Route::any('adminPosition', 'AdminMemberController@adminPositionList');//职员职位列表
        Route::any('passWordEdit', 'AdminMemberController@passWordEdit');//编辑个人密码
        Route::any('depList', 'RoleController@departmentList');//部门列表管理
        Route::any('depAdd', 'RoleController@departmentAdd');//部门添加功能
        Route::any('depAddPage', 'RoleController@departmentAddPage');//部门添加页面
        Route::any('positionAdd/{id}', 'RoleController@positionAdd');//职位添加
        Route::any('ConstructIndex', 'ConstructionController@Index');//工程信息页面
        Route::any('detailInformation/{id}', 'ConstructionController@detailInformationList');//工程信息详情页面
        Route::any('detailEditPage/{id}', 'ConstructionController@decorationInformationEditPage');//工程信息编辑页面
        Route::any('detailEdit/{id}', 'ConstructionController@decorationInformationEdit');//详情编辑功能

        Route::any('decorationEdit/{id}', 'RoleController@decorationEdit');//详情编辑功能

        Route::any('staffList', 'StaffController@staffList');//职员列表
        Route::any('staDelete/{id}', 'StaffController@staDelete');//软删除职员
        Route::any('sectionList', 'StaffController@sectionList');//部门管理列表

    });
});

Route::any('form',"Web\IndexController@index");
Route::any('wxForm','Wx\IndexController@formTest');
Route::any('wx','Wx\IndexController@getAccessToken');
Route::any('getSAT','Wx\IndexController@getSpecialAccessToken');


Route::any('staffAdd', 'Admin\StaffController@staffAdd');//新增职员
Route::any('staffedit/{id}', 'Admin\StaffController@staffedit');//修改职员
Route::any('staffedit', 'Admin\StaffController@staffedit');//编辑职员列表
Route::any('PositionList', 'Admin\StaffController@PositionList');//职员职位列表
Route::any('sectionList', 'Admin\StaffController@sectionList');//部门管理列表
Route::any('sectionAdd', 'Admin\StaffController@sectionAdd');//部门新增
Route::any('sectionedit/{id}', 'Admin\StaffController@sectionedit');//部门新增
Route::any('positionAdd/{id}', 'Admin\StaffController@positionAdd');//职位添加
Route::any('projectList', 'Admin\ProjectController@projectList');//工程管理
Route::any('projectAdd', 'Admin\ProjectController@projectAdd');//工程添加
Route::any('projectEdit/{id}', 'Admin\ProjectController@projectEdit');//工程修改
Route::any('projectInfo/{id}', 'Admin\ProjectController@projectInfo');//工程详情
Route::any('contract_flow/{id}', 'Admin\ProjectController@contract_flow');//流程列表
Route::any('contract_flowAdd', 'Admin\ProjectController@contract_flowAdd');//流程添加
Route::any('contractEdit/{id}', 'Admin\ProjectController@contractEdit');//流程修改


Route::any('aa', 'Admin\ProjectController@aa');//流程修改
