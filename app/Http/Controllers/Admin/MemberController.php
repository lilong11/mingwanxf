<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/29
 * Time: 15:26
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Wx\MessagePushController;
use App\Http\Logic\MemberLogic;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\WxUser;
use Illuminate\Http\Request;

class MemberController extends AdminController{
    protected $viewUrl = 'admin/member/';
    /*
     * 用户信息表
     * */
    public function memberList(Request $request){
        $key_word = $request->post('keyWord');
//        dump($key_word);
        $where = [];
        if (!empty($key_word)){
            $where = [
//                 ['user_name','like',"%$key_word%"],
                ['mobile_number','=',$key_word]
            ];
        }
        $user = new User();
        $list = $user->join('user_approach','user.approach_id','=','user_approach.Id')->leftJoin('admin_information','user.referrer_id','=','admin_information.Id')->select('user.status','user_approach.ua_type','user.mobile_number','user.user_name','user.create_time','user.grade','user.Id','real_name','approach_id')->where($where)->distinct()->paginate(15);
//        dump($list);
//        exit();
        $data['list'] = $list;
        return view($this->viewUrl.'memberList',$data);
    }

    public function memberStop($id){
        if (!empty($id)){
            date_default_timezone_set('Asia/Shanghai');
            $now = date('Y-m-d H:i:s',time());
            $user = new User();
            $data = [
                'status' => -1,
                'update_time' => $now
            ];
            if (strpos($id,',') != false){
                try{
                    $id = explode(',',trim($id,','));
                    $user->whereIn('id',$id)->update($data);
                    return $this->success('','已禁用');
                }catch (\Exception $e){
                    return $this->error('','禁用失败');
                }
            }else{
                try{
                    $user->where('id',$id)->update($data);
                    return $this->success('','已禁用');
                }catch (\Exception $e){
                    return $this->error('','禁用失败');
                }
            }

        }else{
            return $this->error('','信息不能为空');
        }
    }
    public function memberStart($id){
        if (!empty($id)){
            date_default_timezone_set('Asia/Shanghai');
            $now = date('Y-m-d H:i:s',time());
            try{
                $user = new User();
                $data = [
                    'status' => 1,
                    'update_time' => $now
                ];
                $user->where('id',$id)->update($data);
                return $this->success('','已启用');
            }catch (\Exception $e){
                return $this->error('','启用失败');
            }
        }else{
            return $this->error('','信息不能为空');
        }
    }
    /*
     * 用户列表页的
     * 用户订单列表
     * */
    public function memberOrderList($id){
        if (!empty($id)){
            $orWhere = [];
//            exit();
            $userOrder = new UserOrder();
            $list = $userOrder->join('user_site','user_order.site_id','=','user_site.Id')->select('user_order.Id','us_type','user_id','interior_area','user_order.status','create_time','payment_status')->where('user_id','=',$id)->orWhere($orWhere)->paginate(15);
//            dump($list);
            $date['list'] = $list;
            $date['id'] = $id;
//            dump($date);
        }
        return view($this->viewUrl.'memberOrder',$date);
    }

    public function memberEdit($id){
        return view($this->viewUrl.'memberEdit');
    }

//    微信用户操作
    /*
     * 微信用户操作列表
     * */
    public function wxUserList(Request $request){
        $key = '';
        if (!empty($request->post('keyword'))){
            $key = $request->post('keyword');
//            dump($key);
//            exit();
        }
        $list = (new MemberLogic())->queryWithPage($key);
        if ($list['code'] == -1){
            return $list;
        }
//        dump($list);
        $data = ['list'=>$list['info']];
        return view($this->viewUrl.'wxUserList',$data);
    }

    /*
     * 邀请会员
     * */
    public function memberInvite($id){
//        return $id;
        if (!empty($id)){
            $openid = WxUser::where('Id',$id)->value('openid');
            $adminId = Session('admin')['Id'];
            //编辑信息模板
            $data = ' {
           "touser":"' . $openid . '",
           "template_id":"RZT7VIp1V-LN1wVeez4MU7ckQpZL9f7fCBWbQ5Ydl9M",
           "url":"'.url('wxForm') . '?adminId=' . $adminId . '&openId=' . $openid . '",     
           "data":{
                   "first": {
                       "value":"消息发送测试！",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"test",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"test",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"test",
                       "color":"#173177"
                   }
           }
       }';
            //发送微信消息
            $isSend = (new MessagePushController())->sendMessage($data);
//            return $isSend;
            if ($isSend['errcode'] != 0){
                return $this->error('','发送失败');
            }else{
                return $this->success('','邀请发送成功');
            }
        }
        return $this->error('','参数错误');
    }
}