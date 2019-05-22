<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/1
 * Time: 12:49
 */
namespace App\Http\Controllers\Admin;

use App\Http\Logic\OrderLogic;
use App\Models\AdminInformation;
use App\Models\AdminPosition;
use App\Models\Position;
use App\Models\Staff;
use App\Models\UserOrder;
use App\Models\UserOrderDecoration;
use App\Models\UserOrderPic;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class OrderController extends AdminController{
    public function orderList2(Request $request){
        $key = '';
        if (!empty($request->post())){
            $key = $request->post();
        }
        $list=(new OrderLogic)->queryWithPage($key);
        $data['list'] = $list;
        return view('admin/order/orderList',$data);
    }

    /**
     * 查询订单数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderList(Request $request){
        $status     = $request ->input( 'status' );
        $pay_status = $request ->input('pay_status');
        $list=(new OrderLogic)->queryWithPage1($status,$pay_status);
        $data['list'] = $list;
        return view('admin/order/orderList',$data);

    }

    /*
     * 订单删除
     * */
    public function orderDelete($id){
//        dump($id);
        if (!empty($id)){
            $now = date('Y-m-d h:i:s',time());
            $data = [
                'status' => -2,
                'update_time' => $now
            ];
            $userOrder = new UserOrder();

            if (strpos($id,',') != false){
                $id = explode(',',trim($id,','));
//                dump($id);
            }else{
//                $pt_status = $userOrder->find($id)->payment_status;
                $de_status = $userOrder->find($id)->decoration_status;
//                dump($de_status);
                if ($de_status == -1){
                    try{
                        $where = [
                            ['Id','=',$id],
                            ['payment_status',"<" ,1],
                            ['decoration_status','<',1]
                        ];
                        $userOrder->where($where)->update($data);
                        return $this->success('','订单取消成功');
                    }catch (\Exception $e){
                        return $this->error($e->getMessage(),'订单取消失败');
                    }
                }else{
                    return $this->error('','此订单无法取消');
                }
            }
        }
    }

    /*
     * 装修状态编辑
     * */
//    public function decorationEditPage($id){
//        $info = (new OrderLogic())->decorationInfo($id);
////        dump($info['info'][0]['pic_url']);
//        foreach ($info['info'] as $k=>$v){
//            $info['info'][$k]['pic_arr'] = explode(',',trim($v['pic_url'],','));
//        }
//        $pic_arr_count=count($info['info'][0]['pic_arr']);
////        dump($pic_arr_count);
//        if ($info['code'] == -1){
//            return $info['msg'];
//        }
//        $data=['id'=>$id,'info'=>$info['info'],'count'=>$pic_arr_count];
//        return view('admin/order/orderDecorationEdit',$data);
//    }

/*
* 订单工程信息编辑页面
* */
    public function decorationEditPage($id)
    {
        $info = (new OrderLogic())->decorationInfo($id);
        $infoName =$info['info'][0];
        //各职位的职员名单列表
        $managerList = $this->queryAdminList('项目经理');
        $designer = $this->queryAdminList('设计师');
        $supervisor = $this->queryAdminList('监理');

//        dump($supervisor);
        $infoName['manager']=$managerList;
        $infoName['designer']=$designer;
        $infoName['supervisor']=$supervisor;
        //工程信息里已确定的职员信息
        $isManager = $this->queryAdminInfo($infoName['manager_id']);
        $isDesigner = $this->queryAdminInfo($infoName['designer_id']);
        $isSupervision = $this->queryAdminInfo($infoName['supervision_id']);
        $infoName['isManager'] = $isManager;
        $infoName['isDesigner'] = $isDesigner;
        $infoName['isSupervisor'] = $isSupervision;
        $data = ['info'=>$info['info']];
//        dump($info['info'][0]);
        return view('admin/order/orderDecorationEdit',$data);
    }

    private function queryAdminInfo($data){
        $adminInformation= new AdminInformation();
        $info = $adminInformation->where('Id',$data)->value('real_name');
        return $info;
    }
    private function queryAdminList($data){
        $adminPosition = new AdminPosition();
        $list = $adminPosition->where('position_name',$data)->join('admin_information','position_id','=','admin_position.Id')->select('real_name','admin_information.Id')->get();
        return $list;
    }

//    public function decorationEdit(Request $request){
//        $now = date('Y-m-d h:i:s',time());
//        if ($request->isMethod('post')){
//            $data = $request->post();
////            dump($data);
//            $orderPic = new UserOrderPic();
//            $userOrder = new UserOrder();
//            $checkStatus = $userOrder->find($data['id'])->status;
////            dump($checkStatus);
////            return false;
//            if ($checkStatus == -2){
//                return $this->error('','此订单已取消');
//            }
//            $checkId = $orderPic->where('order_id',$data['id'])->value('Id');
//            if ($checkId == null){
//                DB::beginTransaction();
//                try{
//                    $pic_data = [
//                        'pic_url' => $data['carousel_pic'],
//                        'order_id' => $data['id'],
//                        'create_time' => $now,
//                        'update_time' => $now,
//                    ];
//                    $orderPic->insert($pic_data);
//                    $order_data = [
//                        'decoration_status' => $data['position'],
//                    ];
//                    $userOrder->where('Id',$data['id'])->update($order_data);
//                    DB::commit();
////                    dump(Response()->json($this->success('','提交成功')));
////                    return false;
//                    return Response()->json($this->success('','提交成功'));
//                }catch (\Exception $e){
//                    DB::rollBack();
//                    return $this->error($e->getMessage(),'提交失败，请稍后再试');
//                }
//            }else{
//                DB::beginTransaction();
//                try{
//                    $pic_data = [
//                        'pic_url' => $data['carousel_pic'] ,
//                        'order_id' => $data['id'],
//                        'update_time' => $now,
//                    ];
//                    $orderPic->where('order_id',$data['id'])->update($pic_data);
//                    $order_data = [
//                        'decoration_status' => $data['position'],
//                    ];
//                    $userOrder->where('Id',$data['id'])->update($order_data);
//                    DB::commit();
//                    return Response()->json($this->success('','提交成功'));
//                }catch (\Exception $e){
//                    DB::rollBack();
//                    return $this->error($e->getMessage(),'提交失败，请稍后再试');
//                }
//            }
//        }
//    }

    /*
    * 订单工程编辑
    * */
    public function decorationEdit(Request $request)
    {
//          dump($request->post());
          $data = $request->post();
          $orderDecoration = new UserOrderDecoration();
         if (empty($data['id'])){
             return $this->error('','订单ID不能为空');
         }
         if (empty($data['contract']) || empty($data['address']) || empty($data['name']) || empty($data['designer']) || empty($data['manager'])){
             return $this->error('','信息不能为空');
         }
         //检查订单是否被取消
         $userOrder = new UserOrder();
         $checkStatus = $userOrder->find($data['id'])->status;
//            dump($checkStatus);
//            return false;
        if ($checkStatus == -2){
            return $this->error('','此订单已取消');
        }
         //获取装修状态，确定状态以及是否已经建立了表单
         $statusCheck = $orderDecoration->where('order_id', $data['id'])->value('decoration_status');
        try{
            if ($data['decoration_status'] == 2){
                return $this->error('','此状态禁止手动选择');
            }
            date_default_timezone_set('Asia/Shanghai');
            $now = date('Y-m-d H:i:s',time());
         if ($statusCheck == null){//如果装态为空插入新信息
             if ($data['decoration_status'] == -1){
                 $data = [
                     'contract_number' => $data['contract'],
                     'order_id' => $data['id'],
                     'project_address' => $data['address'],
                     'project_name' => $data['name'],
                     'decoration_status' => $data['decoration_status'],
                     'designer_id' => $data['designer'],
                     'manager_id' => $data['manager'],
                     'supervision_id' => $data['supervisor'],
                 ];
             }else{
                 $data = [
                     'contract_number' => $data['contract'],
                     'order_id' => $data['id'],
                     'project_address' => $data['address'],
                     'project_name' => $data['name'],
                     'start_time' => $now,
                     'decoration_status' => $data['decoration_status'],
                     'designer_id' => $data['designer'],
                     'manager_id' => $data['manager'],
                     'supervision_id' => $data['supervisor'],
                 ];
             }
//             dump($data);
//             return false;
             $orderDecoration->fill($data)->save();
         }else {//如果不为空更新数据
             $Id = $orderDecoration->where('order_id',$data['id'])->value('Id');
             if ($data['decoration_status'] == -1){//发送过来的状态是未开工时
                 $data = [
                     'contract_number' => $data['contract'],
                     'order_id' => $data['id'],
                     'project_address' => $data['address'],
                     'project_name' => $data['name'],
                     'start_time' => null,
                     'decoration_status' => $data['decoration_status'],
                     'designer_id' => $data['designer'],
                     'manager_id' => $data['manager'],
                     'supervision_id' => $data['supervisor'],
                 ];
             }else{
                 $data = [
                     'contract_number' => $data['contract'],
                     'order_id' => $data['id'],
                     'project_address' => $data['address'],
                     'project_name' => $data['name'],
                     'start_time' => $now,
                     'decoration_status' => $data['decoration_status'],
                     'designer_id' => $data['designer'],
                     'manager_id' => $data['manager'],
                     'supervision_id' => $data['supervisor'],
                 ];
             }
//             dump($data);
//             return false;
             $orderDecoration->where('Id',$Id)->update($data);
         }
             return $this->success('','信息提交成功');
         }catch (\Exception $e){
             return $this->error($e->getMessage(),'信息提交失败');
         }
    }

    public function decorationPic(Request $request){
        if (!$request->hasFile('image')){
            return $this->error('','请上传图片文件');
        }
        $file = $request->image;
        $info = $this->picUpload($file);
//        dump($info);
        return Response()->json($this->success($info, '图片上传成功'));
    }
}