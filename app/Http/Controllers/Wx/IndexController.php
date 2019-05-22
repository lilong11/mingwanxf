<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 9:41
 */
namespace App\Http\Controllers\Wx;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WxUser;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use App\Http\Controllers\Web\IndexController;

class IndexController extends ApiController {
    protected $appId = 'wx9165ad154d6b7e52';
    protected $appSecret = '9799c390fa4f122cbbf31fb9d292cbb9';

    /*
     * 获取token
     * */
    public function getAccessToken(){
        //考虑过期问题，将获取的token存储到临时文件
        $lifeTime = 7200;
        $token_file = public_path().'/access_token';
        if (file_exists($token_file) && time()-filemtime($token_file) < $lifeTime){
            return file_get_contents($token_file);
        }
        //目标URL
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $output = $this->curl($url);
            $wxBack = json_decode($output,true);
            if (isset($wxBack['errcode'])){
                return $wxBack['errmsg'];
            }
            $token =  $wxBack['access_token'];
            //创建临时文件保存token
            file_put_contents($token_file, $token);
            return response()->json($token);
    }

    /*
     *获取特殊token
     * */
    public function getSpecialAccessToken($code){
//        return $code;
        if (empty($code)){
            $redirectUri = urlencode(url('getSAT'));
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appId . '&redirect_uri=' . $redirectUri . '&response_type=code&scope=snsapi_userinfo&state=1&connect_redirect=1#wechat_redirect';
            return redirect()->away($url);
        }else{
            //获取openid
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$code&grant_type=authorization_code";
            $output = $this->curl($url);
            $wx_back = json_decode($output, true);
            if (isset($wx_back['errcode'])){
                return $wx_back['errmsg'];
            }
            return $wx_back;
        }
    }

    /*
     * 临时代码
     * 微信会员邀请
     * */
    public function formTest(Request $request)
    {
        if ($request->isMethod('post')){
            $data =$request->post();
            $user = new User();
            $wxUser = new WxUser();
            $check = $this->data_check($data);
            if ($check['status'] == -1){
                return ['code'=>-1,'msg'=>$check['info']];
            }
            $now = date('Y-m-d h:i:s',time());
            if (!empty($data['openid']) && !empty($data['adminId'])){
                $checkWxExists = $user->where('wx_openid',$data['openid'])->value('Id');//检查是否已是优惠会员
                if ($checkWxExists != null){
                    return ['code'=>-1,'msg'=>'会员已存在'];
                }
                $checkUserInfo = $user->where(['mobile_number'=>$data['mobile']])->value('Id');//检查是否已是普通会员
//                return $checkUserInfo;
                if ($checkUserInfo != null){//信息已存在修改数据升级为优惠会员
                    DB::beginTransaction();
                    try{
                        $user_data = [
                            'wx_openid' => $data['openid'],
                            'referrer_id' => $data['adminId'],
                            'update_time'=>$now,
                            'approach_id' => $data['approach'],
                            'status' => 1,
                            'grade'=>2
                        ];
                        $user->where('Id',$checkUserInfo)->update($user_data);
                        $wxUser->where('openid',$data['openid'])->update(['status'=>1]);
                        DB::commit();
                        return ['code'=>0,'msg'=>'提交升级成功'];
                    }catch (\Exception $e){
                        DB::rollBack();
                        return ['code'=>-1, 'info'=>$e->getMessage(), 'msg'=>'提交失败请稍后再试'];
                    }
                }else{
                    //信息不存在正常存入数据
                    DB::beginTransaction();
                    try{
                        $user_data = [
                            'wx_openid' => $data['openid'],
                            'referrer_id' => $data['adminId'],
                            'mobile_number' => $data['mobile'],
                            'user_name' => urlencode($data['name']),
                            'create_time' => $now,
                            'approach_id' => $data['approach'],
                            'status' => 1,
                            'grade'=>2
                        ];
                        $user->insert($user_data);
                        $wxUser->where('openid',$data['openid'])->update(['status'=>1]);
                        DB::commit();
                        return ['code'=>0,'msg'=>'提交成功'];
                    }catch (\Exception $e){
                        DB::rollBack();
                        return ['code'=>-1,'info'=>$e->getMessage(),'msg'=>'申请提交失败'];
                    }
                }
            }else{
                return ['code'=>-1,'msg'=>'重要参数不能为空'];
            }
        }
        return view('wx/form');
    }

    protected function data_check($data){
        if(empty($data['mobile']) || preg_match('/^1[0-9]\d{9}$/',$data['mobile']) == false){
            return $list=  ['status' => -1,'info'=>'手机号码信息错误'];
        }
        if (empty($data['name']) || strlen($data['name']) > 12){
            return $list=  ['status' => -1,'info'=>'姓名信息错误'];
        }
        if(empty($data['approach']) || preg_match('/^[1-9][0-9]*$/',$data['approach']) == false){
            return $list=  ['status' => -1,'info'=>'非法信息输入'];
        }
//        if(empty($data['site']) || preg_match('/^[1-9][0-9]*$/',$data['site']) == false){
//            return $list=  ['status' => -1,'info'=>'非法信息输入'];
//        }
        return $list=  ['status' => 1];
    }

}