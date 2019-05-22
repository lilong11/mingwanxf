<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/4
 * Time: 14:38
 */
namespace App\Http\Logic;

use App\Models\AdminInformation;

class AdminLogic extends Logic{

    public function AdminInfoQueryWithPage ($key){
        $adminInformation = new AdminInformation();
        $where = [];
        $orWhere = [];
        if ($key != null){
            $where[] = ['real_name','like',"%$key%"];
            $orWhere[] = ['ad_mobile','like',"%$key%"];
        }
        $list = $adminInformation->join('admin_position','admin_position.Id','=','admin_information.position_id')->join('admin_department','admin_department.Id','=','admin_position.department_id')->select('admin_information.Id','admin_information.status','real_name','ad_mobile','position_name','department_name','login_time','create_time','email_address','update_time')->where($where)->orWhere($orWhere)->paginate(15);
        return $list;
    }
}