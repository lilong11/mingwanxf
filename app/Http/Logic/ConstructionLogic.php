<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30
 * Time: 11:07
 */
namespace App\Http\Logic;

use App\Models\AdminInformation;
use App\Models\UserApproach;
use App\Models\UserOrderDecoration;

class ConstructionLogic extends Logic{
    /*
     * 工程列表信息
     * */
    public function queryWithPage($key)
    {
        $where = [];
        if ($key != null){
            $where[] = ['decoration_status','=',$key];
        }
        $orderDecoration = new UserOrderDecoration();
        $info = $orderDecoration->select('contract_number','user_order_decoration.Id','project_address','project_name','user_order_decoration.decoration_status','designer_id','manager_id','supervision_id','start_time','end_time')->where($where)->orderBy('Id','asc')->paginate(15);
        $adminInformation = new AdminInformation();
        foreach ($info as  $k=>$v){
            $info[$k]['supervision'] = $adminInformation->where('Id',$v['supervision_id'])->value('real_name');
        }
        foreach ($info as  $k=>$v){
            $info[$k]['designer'] = $adminInformation->where('Id',$v['designer_id'])->value('real_name');
        }
        foreach ($info as  $k=>$v){
            $info[$k]['manager'] = $adminInformation->where('Id',$v['manager_id'])->value('real_name');
        }
        return $info;
    }

    /*
     *详情页信息
     *  */
    public function queryInfoNotPage($id)
    {
//        return $id;
        $orderDecoration = new UserOrderDecoration();
        $info = $orderDecoration->where('user_order_decoration.Id',$id)->join('user_order','order_id','=','user_order.Id')->join('user','user_order.user_id','=','user.Id')->select('mobile_number','user_name','interior_area','contract_number','user_order_decoration.Id','project_address','project_name','user_order_decoration.decoration_status','designer_id','manager_id','supervision_id','start_time','end_time','approach_id','acceptance_status','acceptance_sheet')->get();
        $infoDetail = $info[0];
//        return $info;
        $approach = UserApproach::where('Id',$infoDetail['approach_id'])->value('ua_type');
        //工程信息里已确定的职员信息
        $isManager = $this->queryAdminInfo($infoDetail['manager_id']);
        $isDesigner = $this->queryAdminInfo($infoDetail['designer_id']);
        $isSupervision = $this->queryAdminInfo($infoDetail['supervision_id']);
        $info[0]['approach'] = $approach;
        $info[0]['manager'] = $isManager;
        $info[0]['designer'] = $isDesigner;
        $info[0]['supervision'] = $isSupervision;
        return $info;
    }
    private function queryAdminInfo($data){
        $adminInformation= new AdminInformation();
        $info = $adminInformation->where('Id',$data)->value('real_name');
        return $info;
    }

}