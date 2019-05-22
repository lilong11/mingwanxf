<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/10
 * Time: 15:24
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use http\Env\Request;
use App\Http\Logic\RoleLogic;
use App\Models\Position;
use App\Models\Section;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends AdminController
{
    /**
     * 查询职员列表数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staffList(Request $request){
        $username = $request->input('username');
        $phone    = $request->input('phone');
        $map = array();
        $map['sts'] = 0;
        if(!empty($username)){
            $map['username'] = $username;
        }
        if(!empty($phone)){
            $map['phone'] = $phone;
        }
        $list = Staff::where($map)->orderBy('id','desc')->paginate(10);//获取数据
        foreach ($list as $k=>$v){//循环数据
            $data = Staff::find(1)->position->toArray();//获取关联表数据
            $list[$k]['position_name'] = $data['position_name'];//赋值字段
            $vs = Section::where('id',$data['pid'])->get();//查询二级关联数据
            foreach ($vs as $kk=>$vv){//循环二级数据
                $list[$k]['name'] = $vv['name'];//赋值二级数据给一级
            }
        }
        return  view('admin/gs/staffList',['list'=>$list]);
    }

    /**
     * 新增数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staffAdd(Request $request){
        date_default_timezone_set('Asia/Shanghai');
        if ($request->isMethod('post')){
            $where = $request->post();
            $adminDepartmen = new Staff();
            $username = $request->post('username');
            $phone    = $request->post('phone');
            $age      = $request->post('age');
            $sex      = $request->post('sex');
            $pid      = $request->post('position');
            $email    = $request->post('email');
            $deName = $adminDepartmen->where('username',$where['username'])->value('username');
            if ($deName == null){
                try{
                    $data = ([
                        'username' => $username,
                        'phone'    => $phone,
                        'age'      => $age,
                        'sex'      => $sex,
                        'pid'      =>$pid,
                        'create_time'=>time(),
                        'email'    =>$email
                    ]);
                    $adminDepartmen->create($data);
                    return $this->success('','添加成功') ;
                }catch (\Exception $e){
                    return $this->error($e->getMessage(),'添加失败') ;
                }
            }
            return$this->error('','该员工已存在') ;
        }
        $adminDepartment = new Section();
        $depInfo = $adminDepartment->where('sts',0)->get();
        $data['list'] = $depInfo;
        return view('admin/gs/staffAdd',$data);
    }

    /*
    * 通过监听部门ID实时获取职位
    * */
    public function PositionList(Request $request){
//        dump($request->post());
        $data = $request->post('did');
        if (!empty($data)){
            $adminPosition = new Position();
            $posInfo = $adminPosition->where([
                ['pid','=',$data],
                ['sts','=',0]
            ])->get();
            return $this->success($posInfo);
        }else{
            return $this->error('','非法路径，数值为空');
        }
    }

    /**
     * 删除职员信息
     * @param $id
     * @return mixed
     */
    public function staDelete($id){
        $list = DB::table('staff')->where('id',$id)->update(['sts'=>1]);
        return $list;
    }

    /**
     * 修改职员信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staffedit(Request $request,$id){
        $where = $request->post();
        $sta = new Staff();
//        $list = $sta->where('id',$id)->first();
//
//        $data = Staff::find(1)->position->toArray();//获取关联表数据
//        $list['position_name'] = $data['position_name'];//赋值字段
//        $vs = Section::where('id',$data['pid'])->get();//查询二级关联数据
//        foreach ($vs as $kk=>$vv){//循环二级数据
//            $list['name'] = $vv['name'];//赋值二级数据给一级
//        }
//        $section = Section::where('sts',0)->get();
//        $list['info'] = $section;
        $adminInformation = new Position();
        $adminDepartment = new Section();
        if(!empty($where)){
            $username = $request->input('username');
            $phone    = $request->input('phone');
            $age      = $request->input('age');
            $sex      = $request->input('sex');
            $email    = $request->input('email');
//            $pid      = $request->input('pid');
                $data = [
                    'username'        => $username,
                    'phone'           => $phone,
                    'age'             => $age,
                    'sex'             => $sex,
                    'email'           => $email,
                    'update_time'     => time()
                ];
                $sta->where('id',$id)->update($data);
                return $this->success('','修改成功') ;
        }else{
            $search = $sta
                ->join('position','position.id','=','staff.pid')
                ->join('section','section.id','=','position.pid')
                ->where('staff.id','=',$id)
                ->select('staff.id','username','phone','position_name','sex','age','name','email','section.id as dId','position.id as pId');
            $list = $search->first();
            $Did = $search->value('dId');
            $department_list = $adminDepartment->where([
                ['id','!=', $Did]
            ])->get();

            $data['list'] = $list;
            $data['dList'] = $department_list;
            return view('admin/gs/staffedit',$data);
        }
    }


    /**
     * 部门管理列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sectionList(Request $request){
        $name = $request->input('name');
        $list = (new RoleLogic())->sectioninfo($name);
        $date['list'] = $list['list'];
        foreach ($list['Plist'] as $k =>$v) {
            foreach ($v as $kk => $vv){
                $date['Plist'][] = $vv;
            }
        }
        return  view('admin/gs/sectionList',$date);
    }

    /**
     * 部门新增
     * @param Request $request
     * @return array
     */
    public function sectionAdd(Request $request){
        if ($request->isMethod('post')){
            $adminDepartmen = new Section();
            $position = new Position();
            $name = $request->post('name');
            $position_name = $request->post('position_name');
            $phone    = $request->post('status');
                try{
                    $data1 = $adminDepartmen->where('name',$name)->value('name');//查询部门是否存在
                    if ($data1 == null){//如果不存在则新增部门
                        $data = ([
                            'name' => $name,
                            'status'=>$phone,
                            'create_time'=>time()
                        ]);
                        $id =  $adminDepartmen->insertGetId($data);
                    }else{
                        $id = $adminDepartmen->where('name',$name)->value('id');
                    }
                    $where1 = $position->where('position_name',$position_name)->value('position_name');//查询职位是否存在
                    if ($where1 == null){//如果不存在则新增职位
                        $where = ([
                            'position_name'=>$position_name,
                            'pid'=>$id,
                            'status'=>0,
                            'create_time'=>time()
                        ]);
                        $position->insertGetId($where);
                    }
                    return $this->success('','添加成功') ;
                }catch (\Exception $e){
                    return $this->error($e->getMessage(),'添加失败') ;
                }
        }
        return view('admin/gs/sectionAdd');
    }

    /**
     * 修改部门
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sectionedit(Request $request ,$id){
        $where = $request->post();
        $section = new Section();
        if(!empty($where)){
            $username = $request->input('name');
            $position_name    = $request->input('position_name');
            $status      = $request->input('status');
            $data = [
                'name'        => $username,
                'status'             => $status,
                'update_time'     => time()
            ];
//            dd($data);
            DB::table('section')->where('id',$id)->update($data);
            return $this->success('','修改成功') ;
        }else{
            if (!empty($id)){
                $position = new Position();
                $list = Section::where('id',$id)->first();
                $list['position_name'] = $position->where('pid',$list['id'])->value('position_name');//查询职位是否存在
                $data =['list'=>$list] ;
                return view('admin/gs/sectionedit',$data);
            }
            return json_encode(0,'数据不正确');
        }
    }

    /**
     * 添加职位
     * @param $id
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function positionAdd($id,Request $request){
        if ($request->isMethod('post')){
            $name = $request->post('position_name');
            $adminPosition = new Position();
            //判断参数是否为空
            if (!empty($name)){
                $check = $adminPosition->where([
                    ['pid','=',$id],
                    ['position_name','=',$name]
                ])->value('position_name');
                //判断是否已经存在
                if ($check == null){
                    $data = [
                        'pid' => $id,
                        'position_name' => trim($name),
                        'status' => 1,
                        'create_time'=>time()
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
        return view('admin/gs/positionAdd',$data);
    }


}