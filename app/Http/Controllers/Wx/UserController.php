<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/17
 * Time: 14:09
 */
namespace App\Http\Controllers\Wx;

use App\Http\Controllers\ApiController;
use App\Http\Logic\UserLogic;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController{
    /*
     * 获取用户信息
     * */
    public function getUserInfo(Request $request){
        $code = $request->input('code');
        $info = (new IndexController())->getSpecialAccessToken($code);
        $access_token = $info['access_token'];
        $openid = $info['openid'];
//        return $info;
        $get_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $info = $this->curl($get_info_url);
        $info_back = json_decode($info, true);
        $check= (new UserLogic())->wxUserExist($info_back['openid']);
        if ($check['code'] == -1){
//            $saveInfo = (new UserLogic())->saveInfo($info_back);
            return $check;
        }
        $insertUser = (new UserLogic())->insertUserInfo($info_back);
//        $userInfo = (new UserLogic())->wxUserExist($insertUser);
//        session(['user'=>$userInfo]);
        return $insertUser;
    }
}