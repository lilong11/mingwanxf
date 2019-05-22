<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/3
 * Time: 14:48
 */
namespace App\Http\Logic;

use App\Models\AdminDepartment;
use App\Models\AdminPosition;
use App\Models\Position;
use App\Models\Section;

class RoleLogic extends Logic{
    public function queryWithPage2($key){
        $where = [];
        if ($key != ''){
            $where[] = ['department_name' ,'like',"%$key%"];
        }
        $adminDepartment = new AdminDepartment();
        $list = $adminDepartment->where($where);
        $Dlist = $list->select( 'Id','remark','department_name')->paginate(15);
        $id = $list->pluck('Id');
//        dump($id);
        foreach ($id as $k=>$v) {
            $Plist[] = AdminPosition::where('department_id',$v)->join('admin_department','admin_department.Id','=','admin_position.department_id')->select('admin_department.Id as did','admin_position.Id as pid','position_name','admin_position.status')->get();
        }
//            dump($Plist);
        $data = ['Dlist'=>$Dlist,'Plist'=>$Plist];
        return $data;
    }


    public function sectioninfo($name){
        $map =array();
        if(!empty($name)){
            $map['name'] = $name;
        }
        $list = Section::where($map)->orderBy('id','desc')->paginate(10);//获取数据
        $id = Section::where($map)->pluck('id');
        $vs = [];
        foreach ($id as $kk=>$vv){//循环二级数据
            $Plist[] = Position::where('pid',$vv)->join('section','section.id','=','position.pid')->select('section.id as did','position.id as pid','position_name','position.status')->get();
            $vs = $Plist;
        }

        $data = ['list'=>$list,'Plist'=>$vs];
        return $data;
    }



    public function queryWithPage1($name){
        $where = array();
        if ($name != ''){
            $where['position_name'] = ['like',"%$name%"];
        }
        $adminDepartment = new AdminPosition();
        $list = $adminDepartment->where($where);
        $Dlist = $list->where('pid','=',0)->paginate(15);
        foreach ($Dlist as $k=>$v){
            $Dlist[$k]['cid'] = $adminDepartment->where('pid','=',$v['id'])->get();
        }
//        $id = $list->pluck('Id');
//        print_r($id);
//        dump($id);
//        foreach ($Dlist as $k=>$v) {
//            $Plist[] = AdminPosition::where('department_id',$v['Id'])->join('admin_department','admin_department.Id','=','admin_position.department_id')->select('admin_department.Id as did','admin_position.Id as pid','position_name','admin_position.status')->get();
//        }

//            dump($Plist);
//        $data = ['Dlist'=>$Dlist,'Plist'=>$Plist];
        return $Dlist;
    }


    public function editinfo($id){
        $adminDepartment = new AdminPosition();
        $list = $adminDepartment->where('Id','=',$id)->first();
        $data = $adminDepartment->where('Id','=',$list['pid'])->first();
        $list['name']=$data['position_name'];
//        print_r(json_encode($list));
        return $list;
    }


}