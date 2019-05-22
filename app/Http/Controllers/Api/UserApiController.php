<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 16:50
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Logic\UserLogic;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends ApiController{
    public function get_info(Request $request){
        $data = $request->input();
        $check = $this->data_check($data);
        if ($check['status'] == -1){
            return $this->json($check);
        }
        $list = (new UserLogic())->insert_info($data);
        return $this->json($list);
    }

    private function data_check($data){
        if(empty($data['mobile']) || preg_match('/^1[0-9]\d{9}$/',$data['mobile']) == false){
            return $list=  ['status' => -1,'info'=>'手机号码信息错误'];
        }
        if (empty($data['name']) || strlen($data['name']) > 12){
            return $list=  ['status' => -1,'info'=>'姓名信息错误'];
        }
        if(empty($data['id']) || !is_numeric($data['id'])){
            return $list=  ['status' => -1,'info'=>'非法信息输入'];
        }
        return $list=  ['status' => 1];
    }
}
