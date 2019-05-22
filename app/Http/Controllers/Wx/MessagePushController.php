<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/13
 * Time: 13:37
 */
namespace App\Http\Controllers\Wx;

use App\Http\Controllers\ApiController;

class MessagePushController extends ApiController{

    /*
     * 获取消息模板列表
     * */
    public function getTemplate(){
        $token = (new IndexController())->getAccessToken();
//        return $token;
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=$token";
        $backInfo = $this->curl($url);
        $result = json_decode($backInfo,true);
        return $result;
    }

    /*
     * 获取模板Id
     * */
    public function getTemplateId(){
        $token = (new IndexController())->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=$token";
        $data = '{"template_id_short":"TM00015"}';
        $backInfo = $this->_requestPost($url,$data);
        $result = json_decode($backInfo,true);
        return $result;
    }

    /*
     * 发送消息
     * */
    public function sendMessage($data){
        $token = (new IndexController())->getAccessToken();
//        return $token;
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $token . '';
        $backInfo = $this->_requestPost($url,$data);
        $result = json_decode($backInfo,true);
       return $result;
    }
}