<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12
 * Time: 11:02
 */
namespace App\Http\Controllers\Wx;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class QRCodeController extends ApiController {
    //微信获取二维码的接口的控制器
    /*
     * 获取二维码ticket
     * */
    public  function getQRCodeTicket($count){
        $token =(new IndexController())->getAccessToken();
//        return $count;
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
        $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": "'. $count .'"}}}';
//        return $data;
        $wxback =$this->_requestPost($url,$data);
        $result = json_decode($wxback,true);
        if (!$wxback){
            return response()->json(['info'=>'数据为空']);
        }
        //处理响应数据
        return $result['ticket'];
    }

    /*
     * 获取二维码图像
     * */
    public function getQRCode(Request $request){
        $count = $request->input('userId');
//        $userId = Session('admin');
//        return $userId;
        if (empty($count)){
            return response()->json(['info'=>'参数不能为空']);
//            $count = '';
        }
        $ticket = $this->getQRCodeTicket($count) ;
//        return $ticket;
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
        $wxBack = (new IndexController())->curl($url);
//        $result = json_decode($wxBack,true);
        return  response($wxBack,200)->header('Content-Type','image/jpg');

    }

}