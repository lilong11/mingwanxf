<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/2
 * Time: 10:44
 */
namespace App\Http\Controllers\Admin;

use App\Http\Logic\AdminLogic;
use App\Models\AdminDepartment;
use App\Models\AdminInformation;
use App\Models\AdminPosition;
use Illuminate\Http\Request;
use mysql_xdevapi\Session;

class AdminMemberController extends AdminController{
    //公司内部人员列表
    public function adminList(Request $request){
        $key = '';
        if ($request->post('key') != null){
            $key = $request->post('key');
        }
        $list = (new AdminLogic())->AdminInfoQueryWithPage($key);
//        dump($list);
        $data['list'] = $list;
        return view('admin/admin/adminList', $data);
    }

    /*
     * 人员添加
     * */
    public function adminAdd(Request $request){
        date_default_timezone_set('Asia/Shanghai');
        $now = date('Y-m-d H:i:s',time());
        if ($request->isMethod('post')){
            $data = $request->post();
            $name = $request->post('username');
            $mobile = $request->post('phone');
            $pid = $request->post('position');
            $mail = $request->post('email');
            $adminInfomation = new AdminInformation();
            if (!empty($name) && !empty($mobile) && !empty($pid) && !empty($mail) && is_numeric($pid)){
                $check = $this->checkInfo($data);
                if ($check['code'] == -1){
                    return $this->error('',$check['msg']);
                }
                $where = [
                    ['real_name','=',$name],
                    ['ad_mobile','=',$mobile]
                ];
                $check = $adminInfomation->where($where)->value('Id');

                if ($check == null){
                    try{
                        $admin_data = [
                            'real_name' => trim($name),
                            'email_address' => trim($mail),
                            'ad_mobile' => trim($mobile),
                            'ad_password' => md5(md5(trim($mobile))),
                            'position_id' => $pid,
                            'create_time' => $now,
                            'status' => 1
                        ];
                        $adminInfomation->fill($admin_data)->save();
                        return $this->success('','添加成功');
                    }catch (\Exception $e){
                        return $this->error($e->getMessage(),'添加失败');
                    }

                }
            }else{
                return $this->error('','信息不能为空');
            }
        }
//        获取部门信息
        $adminDepartment = new AdminDepartment();
        $depInfo = $adminDepartment->where('status',1)->get();
        $data['list'] = $depInfo;
        return view('admin/admin/adminAdd', $data);
    }
    /*
     * 通过监听部门ID实时获取职位
     * */
    public function adminPositionList(Request $request){
//        dump($request->post());
        $data = $request->post('did');
        if (!empty($data)){
            $adminPosition = new AdminPosition();
            $posInfo = $adminPosition->where([
                ['department_id','=',$data],
                ['status','=',1]
                ])->get();
            return $this->success($posInfo);
        }else{
            return $this->error('','非法路径，数值为空');
        }
    }

    /*
     * 职员信息修改页
     * */
    public function adminEditPage($id){
        if (!empty($id)){
//            dump($id);
            $adminInformation = new AdminInformation();
            $adminDepartment = new AdminDepartment();

            $search = $adminInformation->join('admin_position','admin_position.Id','=','admin_information.position_id')->join('admin_department','admin_department.Id','=','admin_position.department_id')->where('admin_information.Id','=',$id)->select('admin_information.Id','real_name','ad_mobile','position_name','department_name','email_address','admin_department.Id as dId','admin_position.Id as pId');
            $list = $search->get();
            $Did = $search->value('dId');
//            dump($test);
            $department_list = $adminDepartment->where([
                ['status','=',1],
                ['Id','!=', $Did]
            ])->get();

            $data['list'] = $list;
            $data['dList'] = $department_list;
        }
        $userId = Session('admin')['Id'];
//        dump($test);
        if ($id == $userId){
//            dump($list);
            return view('admin/admin/personalEdit',$data);
        }
        return view('admin/admin/adminEdit',$data);
    }

    public function adminEdit(Request $request){
        if ($request->isMethod('post')){
            $data = $request->post();
//            dump($data);
//            exit;
            if (!empty($data['username']) && !empty($data['phone']) && !empty($data['email']) && !empty($data['position']) && is_numeric($data['position'])){
                $check = $this->checkInfo($data);
                if ($check['code'] == -1){
                    return $this->error('',$check['msg']);
                }
                try{
                    $adminInformation = new AdminInformation();
                    $info_data = [
                        'real_name' => trim($data['username']),
                        'email_address' => trim($data['email']),
                        'ad_mobile' => trim($data['phone']),
                        'position_id' => $data['position'],
                        'status' => 1
                    ];
                    $adminInformation->where('Id',$data['id'])->update($info_data);
                    return $this->success('','修改成功');
                }catch (\Exception $e){
                    return $this->error($e->getMessage(),'修改失败请稍后再试');
                }
            }else{
                return $this->error('','信息错误');
            }
        }
    }

    public function passWordEdit(Request $request){
        $adminInformation = new AdminInformation();
        if ($request->isMethod('post')){
            $data = $request->post();
            if (!empty($data['pass']) && preg_match('/^[a-zA-Z\d_]{6,12}$/',$data['pass']) == true){
                if (empty($data['repass'])){
                    return $this->error('','确认密码不能为空');
                }
                if ($data['pass'] != $data['repass']){
                    return $this->error('','密码不一致');
                }
                $userId = Session('admin')['Id'];
                try{
                $info_data['ad_password'] = md5(md5(trim($data['pass'])));
                $adminInformation->where('Id',$userId)->update($info_data);
                return $this->success('','修改成功');
                }catch (\Exception $e){
                    return $this->error($e->getMessage(),'修改失败请稍后再试');
                }
            }
        }
//        if (!empty($id)){
////            $info = $adminInformation->where('Id',$id)->select('Id','ad_password')->get();
//            $data['id'] = $id;
//        }
        return view('admin/admin/passWordEdit');
    }

    /*
     * 检查信息
     * */
    public function checkInfo($data){
        if(preg_match('/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i',$data['email']) == false){
            return $this->error('','邮箱信息错误');
        }
        if(preg_match('/^1[0-9]\d{9}$/',$data['phone']) == false){
            return $this->error('','手机号信息错误');
        }
        if (strlen($data['username']) > 12){
            return $this->error('','姓名信息错误');
        }
    }


}