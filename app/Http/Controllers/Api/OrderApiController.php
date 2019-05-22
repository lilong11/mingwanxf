<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23
 * Time: 16:11
 */
namespace App\Http\Controllers\Api;
 use App\Http\Controllers\ApiController;
 use App\Http\Logic\OrderLogic;
 use App\Models\User;
 use App\Models\UserOrder;
 use http\Env\Response;
 use Illuminate\Http\Request;

 class OrderApiController extends ApiController{
//     private
      function _construct()
     {
         $userOrder = new UserOrder();
     }

     public function userQueryDecorationStatus(Request $request){
          $openid = $request->input('openid');
          if(empty($openid)){
              return $this->json(['code'=>-1,'msg'=>'参数不能为空']);
          }
          $user = new User();
          $userId = $user->where('wx_openid',$openid)->value('Id');
          if (empty($userId)){
              return $this->json(['code'=>-1,'msg'=>'用户不存在，请注册']);
          }
          $info = (new OrderLogic())->decorationQuery($userId);
//          return $this->json($info);
//          if ($info['info'] == null){
//              return $this->json(['code' => -1,'msg'=>'订单状态未更新']);
//          }
          return $this->json($info);
     }
 }