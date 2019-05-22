<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/1
 * Time: 17:40
 */
namespace App\Http\Logic;

use App\Models\UserOrder;
use App\Models\UserOrderDecoration;

class OrderLogic extends Logic{
    public function queryWithPage($key){
        $where = array();
        $orWhere=array();
        $userOrder = new UserOrder();
//        if (!empty($key['phone'])){
//            $num = $key['phone'];
//            $where[] = ['mobile_number','like',"%$num%"];
//        }
//        if (!empty($key['pay_status'])){
//            $pay = $key['pay_status'];
//            $where[] = ['payment_status','=',$pay];
//        }

//         $status = $key['status'];
//        $pay_status = $key[array('pay_status')];
//        print_r($status);
//        print_r($pay_status);


        if ($key != ''){
            $where['user_order.status'] = $key['status'];
            $orWhere['payment_status'] = $key['pay_status'];
        }
        $list = $userOrder->join('user','user_order.user_id','=','user.Id')->leftJoin('user_site','user_site.Id','=','user_order.site_id')->select('user_name','mobile_number','interior_area','user_order.status','payment_status','user_order.create_time','user_order.Id','us_type','user_id','decoration_status')->where($where)->orWhere($orWhere)->orderBy('Id','asc')->paginate(15);

        return $list;
    }

    /**
     * 查询订单表数据
     * @param $status  @ 订单状态
     * @param $pay_status @ 支付状态
     * @return mixed
     */
    public function queryWithPage1($status,$pay_status){
        $where = array();
        $orWhere=array();
        $userOrder = new UserOrder();
        if (!empty($status)){
            $where['user_order.status'] = $status;
        }
        if (!empty($pay_status)){
            $where['payment_status'] = $pay_status;
        }
        $list = $userOrder->join('user','user_order.user_id','=','user.Id')->leftJoin('user_site','user_site.Id','=','user_order.site_id')->select  ('user_name','mobile_number','interior_area','user_order.status','payment_status','user_order.create_time','user_order.Id','us_type','user_id', 'decoration_status')->where($where)->orWhere($orWhere)->orderBy('Id','asc')->paginate(15);
        return $list;
    }

    /*
     * 后台查询装修信息
     * */
//    public function decorationInfo($id){
//        try{
//            $order= new UserOrder();
//            $info = $order->leftJoin('user_order_pic','user_order_pic.order_id','=','user_order.Id')->where('user_order.Id',$id)->select('pic_url','user_order_pic.update_time','user_order.Id','user_order.decoration_status')->get();
//            return $this->success($info);
//        }catch (\Exception $e){
//            return $this->error($e->getMessage(),'查询失败');
//        }
//    }

    public function decorationInfo($id)
    {
        try{
//            $orderDecoration = new UserOrderDecoration();
            $order= new UserOrder();
            $info = $order->where('user_order.Id',$id)->leftJoin('user_order_decoration','user_order_decoration.order_id','=','user_order.Id')->select('contract_number','project_address','project_name','user_order_decoration.decoration_status','user_order.Id','designer_id','manager_id','supervision_id')->get();

            return $this->success($info);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    /*
     * 用户查询个人订单装修状态
     * */
    public function decorationQuery($id)
    {
        $userOrder = new UserOrder();
        try{
            $info = $userOrder->where('user_id',$id)->join('user_order_pic','user_order_pic.order_id','=','user_order.Id')->select('pic_url','user_order_pic.update_time','user_order_pic.create_time')->get();
            foreach ($info as $k=>$v){
                $info['info'][$k]['pic_arr'] = explode(',',trim($v['pic_url'],','));
            }
            return $this->success($info,'200');
        }catch (\Exception $e){
            return $this->error($e->getMessage()) ;
        }

    }


}