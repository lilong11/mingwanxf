<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/2
 * Time: 16:35
 */
namespace App\Http\Controllers\Admin;

use App\Http\Logic\RoleLogic;
use App\Models\AdminDepartment;
use App\Models\AdminPosition;
use Illuminate\Http\Request;

class RoleController extends AdminController{
    /*
     * 角色管理列表
     * */
    public function departmentList(Request $request){
        $key = '';
        if ($request->post('key') != ''){
            $key = $request->post('key');
        }
        $list = (new RoleLogic())->queryWithPage2($key);
//        dump($list);
        $data['Dlist'] = $list['Dlist'];
//        $data['Plist'] = $list['Plist'];
        foreach ($list['Plist'] as $k =>$v) {
//            dump($v);
            foreach ($v as $kk => $vv){
//                dump($vv);
                $data['Plist'][] = $vv;
            }
        }
//        dump($data['Plist']);
//        dump($data['Dlist']);
        return view('admin/role/departmentList',$data);
    }

    public function departmentList2(Request $request){
        $name = $request->input('name');
        $list = (new RoleLogic())->queryWithPage1($name);
        return view('admin/role/departmentList',$list);
    }
    /*
     * 部门管理
     * */
    public function departmentAdd(Request $request){
        if ($request->isMethod('post')){
            $adminDepartmen = new AdminDepartment();
            $name = $request->post('name');
            $mark = $request->post('remark');
            $deName = $adminDepartmen->where('department_name',$name)->value('department_name');
            if ($deName == null){
                try{
                    $data = [
                        'department_name' => $name,
                        'remark' => $mark
                    ];
                    $adminDepartmen->insert($data);
                    return $this->success('','添加成功') ;
//                    return json_encode($this->success('','123')) ;
                }catch (\Exception $e){
                    return $this->error($e->getMessage(),'添加部门失败') ;
                }
            }
            return$this->error('','该部门已存在') ;
        }
    }
    public  function departmentAddPage(){
        return view('admin/role/departmentAdd');
    }

    /*
     * 职位管理
     * */
    public function positionAdd($id,Request $request){
        if ($request->isMethod('post')){
//            dump($request->post());
            $name = $request->post('name');
            $adminPosition = new AdminPosition();
            //判断参数是否为空
            if (!empty($name)){
                $check = $adminPosition->where([
                    ['department_id','=',$id],
                    ['position_name','=',$name]
                ])->value('position_name');
                //判断是否已经存在
                if ($check == null){
//                    dump($name);
                    $data = [
                        'department_id' => $id,
                        'position_name' => trim($name),
                        'status' => 1
                    ];
                    try{
                        $adminPosition->insert($data);
                        return $this->success('','已添加');
                    }catch (\Exception $e){
                        return $this->error($e->getMessage(),'添加失败');
                    }
                }else{
                    return $this->error('',$check.'已存在');
                }
            }else{
                return $this->error('','名称不能为空');
            }
        }
        $data['id'] = $id;
        return view('admin/role/positionAdd',$data);
    }

    /**角色管理查看详情
     * @param $id @ 唯一id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function decorationEdit2($id){
        $list = (new RoleLogic())->editinfo($id);
        $data =['list'=>$list] ;
        return view('admin/role/decorationEdit',$data);
    }
    /**
     * 角色管理编辑
     * @param Request $request
     * @param $id @ 唯一id
     * @return array
     */
    public function decorationEdit(Request $request,$id){
        $list = (new RoleLogic())->editinfo($id);
        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $remark = $request->input('remark');
            $position_name = $request->input('position_name');
            $adminInformation = new AdminPosition();
            try {
                $vs = $adminInformation->where('position_name', $name)->first();
                $info_data = [
                    'pid' => $vs['id'],
                    'remark' => $remark,
                    'position_name' => $position_name
                ];
                $adminInformation->where('Id',$id)->update($info_data);
                return $this->success('', '修改成功');
            } catch (\Exception $e) {
                return $this->error($e->getMessage(), '修改失败');
            }
        }
        $data =['list'=>$list] ;
        return view('admin/role/decorationEdit',$data);
    }
}