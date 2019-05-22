<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 11:36
 */
namespace App\Http\Controllers\Admin;

use App\Models\AdminInformation;
use Illuminate\Http\Request;

class LoginController extends AdminController{
    public function adminLogin(Request $request){
//        dump(md5(md5(123456)));
        return view('admin/login');
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function do_login(Request $request)
    {
        date_default_timezone_set('Asia/Shanghai');
        $now = date('Y-m-d H:i:s',time());
        $username = $request->post('username');
        $password = $request->post('password');
//        dump($request->post());
//        exit;
        if (empty($username) || empty($password)){
            return response()->json($this->error('','信息不能为空'));
        }
        if (preg_match('/^[a-zA-Z\d_]{6,12}$/',$password) == false){
            return response()->json($this->error('','非法信息输入'));
        }
        $where = [
            'real_name'=>$username,
            'status'=>1,
            'ad_password'=>md5(md5($password)),
        ];
        $adminInformation = new AdminInformation();
        $login_true = $adminInformation->where($where)->first();
//        dump($login_true);
//        exit;
        if($login_true){
            session(['admin' => $login_true]);
            $up_login_time = AdminInformation::where($where)->update(['login_time'=> $now]);
            return response()->json($this->success($login_true,'登录成功'));
        }else{
            return response()->json($this->error('error','登录失败,用户名或密码错误'));
        }
    }

    /*
     * 退出登录
     * */
    public function login_out()
    {
        session(['admin'=>'']);
        return view('admin/login');
    }
}