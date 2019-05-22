<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 18:09
 */
namespace App\Http\Logic;
 use App\Models\User;
 use App\Models\WxUser;
 use test\Mockery\ReturnTypeObjectTypeHint;

 class UserLogic extends Logic{

     /*
      * 添加用户信息
      * */
     public function insert_info($data){
         $name = $data['name'];
         $mobile =  $data['mobile'];
         $reference =  $data['id'];
         $user = new User();
         $now = date('Y-m-d h:i:s',time());
         $checkId = $user->where([
             ['mobile_number','=',$mobile],
             ['user_name','=',$name]
         ])->value('Id');
         if ($checkId == null){
             try{
                 $user_data=[
                     'user_name' => trim($name),
                     'mobile_number' =>trim($mobile),
                     'approach_id' =>2,
                     'create_time'=> $now,
                     'status'=>1,
                     'grade' => 2,
                     'referrer_id'=>trim($reference)
                 ];
                 $user->insert($user_data);
                 return $this->success('','加入成功');
             }catch (\Exception $e){
                 return $this->error($e->getMessage(),'加入失败');
            }
         }else{
             $this->error('',' 用户已存在');
         }
     }

//     微信用户信息处理
 /*
  * 判断微信用户是否存在
  * */
     public function wxUserExist($id){
//         return $id;
         try{
             $wxUser = new WxUser();
             $isExist = $wxUser->where(['openid'=>$id])->value('Id');
//             return $isExist;
             if ($isExist != null){
                 return $this->error($isExist,'用户已存在');
             }else{
                 return $this->success($isExist,'用户不存在');
             }
         }catch (\Exception $e){
             return $this->error($e->getMessage(),'openID查询失败');
         }
     }

     /*
      * 更新用户信息
      * */
     public function saveInfo($data){
         try{
             $now = date('Y-m-d H:i:s',time());
             $user_data = [
                 'nickname'=> urlencode($data['nickname']),
                 'avatar'=>$data['headimgurl'],
                 'last_login_time'=>$now,
             ];
             $wxUser = new WxUser();
             $wxUser->where('openid',$data['openid'])->update($user_data);
             return $this->success('','用户已存在，信息更新成功');
         }catch (\Exception $e){
             return $this->error($e->getMessage(),'更新信息失败');
         }
     }

     /*
      *添加用户信息
      * */
     public function insertUserInfo($data){
         try{
             $now = date('Y-m-d H:i:s',time());
             $user_data = [
                 'openid'=>$data['openid'],
                 'nickname'=>urlencode($data['nickname']),
                 'avatar'=>$data['headimgurl'],
                 'last_login_time'=>$now,
                 'create_time'=>$now,
                 'status'=>-1,
             ];
             $wxUser = new WxUser();
             $wxUser->insert($user_data);
             return $this->success('','插入成功');
         }catch (\Exception $e){
             return $this->error($e->getMessage(),'用户添加失败');
         }
     }
 }