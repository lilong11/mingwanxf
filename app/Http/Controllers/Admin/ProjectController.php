<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 13:52
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\ContractType;
use App\Models\File;
use App\Models\Position;
use App\Models\Project;
use App\Models\Staff;
use App\Models\User;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends AdminController
{

    /**
     * 工程信息列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projectList(Request $request){
        $map = array();
        $username = $request->input('client_name');
        $phone    = $request->input('client_phone');
        if (!empty($username)){
            $map['client_name'] = $username;
        }
        if (!empty($phone)){
            $map['client_phone'] = $phone;
        }
        $projectr = new Project();
        $list = $projectr->where($map)->orderBy('id','desc')->paginate(10);

        foreach ($list as $k=>$v){
            $user = new User();
            $order = new UserOrder();
            $userid = $order->where('id',$v['order_id'])->value('user_id');
//            dd($userid);
            $list[$k]['source'] = $user->where('id',$userid)->value('approach_id');
            $position = new Position();
            $list[$k]['stylist_name'] = $position->where('id',$v['stylist_id'])->value('position_name');
            $list[$k]['pm_name'] = $position->where('id',$v['pm_id'])->value('position_name');
            $list[$k]['supervisor_name'] = $position->where('id',$v['supervisor_id'])->value('position_name');
        }

        return view('admin/project/projectList',['list'=>$list]);
    }

    /**
     * 工程信息新增
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projectAdd2(Request $request){
        $contract_no     = $request->post('contract_no');
        $contract_name   = $request->post('contract_name');
        $australia       = $request->post('australia');
        $acreage         = $request->post('acreage');
        $client_name     = $request->post('client_name');
        $client_phone    = $request->post('client_phone');
        $troa            = $request->post('troa');
        $contract_status = $request->post('contract_status');
        $stylist_id      = $request->post('stylist_id');
        $pm_id           = $request->post('pm_id');
        $supervisor_id   = $request->post('supervisor_id');
        $start_time      = $request->post('start_time');
        $end_time        = $request->post('end_time');
        $orderid         = $request->post('order_id');
        $source          = $request->post('$source');
        if ($request->isMethod('post')){
            $project = new Project();
            $data = ([
                'order_id'=>$orderid,
                'source'  =>$source,
                'contract_no'=>$contract_no,
                'contract_name'=>$contract_name,
                'australia'=>$australia,
                'acreage'=>$acreage,
                'client_name'=>$client_name,
                'client_phone'=>$client_phone,
                'troa'=>$troa,
                'contract_status'=>$contract_status,
                'stylist_id'=>$stylist_id,
                'pm_id'=>$pm_id,
                'supervisor_id'=>$supervisor_id,
                'start_time'=>strtotime($start_time),
                'end_time'=>strtotime($end_time),
                'create_time'=>time(),
            ]);
             $v = DB::table('contract')->insertGetId($data);
             if (!empty($v)){
                 return $this->success('','添加成功') ;
             }else{
                 return$this->error('','添加失败') ;
             }

        }
        $position = new Staff();
        $list = $position->where('sts','=',0)->get();
        $data['list'] = $list;
        return view('admin/project/projectAdd',$data);
    }

    public function projectAdd(Request $request){
        $data = $request->post();
        if ($request->isMethod('post')){
            $project = new Project();
            $data = ([
                'order_id'=>$data['order_id'],
                'source'  =>$data['source'],
                'contract_no'=>$data['contract_no'],
                'contract_name'=>$data['contract_name'],
                'australia'=>$data['australia'],
                'acreage'=>$data['acreage'],
                'client_name'=>$data['client_name'],
                'client_phone'=>$data['client_phone'],
                'troa'=>$data['troa'],
                'contract_status'=>$data['contract_status'],
                'stylist_id'=>$data['stylist_id'],
                'pm_id'=>$data['pm_id'],
                'supervisor_id'=>$data['supervisor_id'],
                'start_time'=>strtotime($data['start_time']),
                'end_time'=>strtotime($data['end_time']),
                'create_time'=>time(),
            ]);
            $v = DB::table('contract')->insertGetId($data);
            if (!empty($v)){
                return $this->success('','添加成功') ;
            }else{
                return$this->error('','添加失败') ;
            }
        }
        $position = new Staff();
        $list = $position->where('sts','=',0)->get();
        $data['list'] = $list;
        return view('admin/project/projectAdd',$data);
    }

    /**
     * 工程信息修改
     * @param Request $request
     * @param $id
     */
    public function projectEdit(Request $request,$id){
        $data = $request->post();
        $project = new Project();
        if (!empty($data)){
            $date = [
                'order_id'=>$data['order_id'],
                'source'  =>$data['source'],
                'contract_no'=>$data['contract_no'],
                'contract_name'=>$data['contract_name'],
                'australia'=>$data['australia'],
                'acreage'=>$data['acreage'],
                'client_name'=>$data['client_name'],
                'client_phone'=>$data['client_phone'],
                'troa'=>$data['troa'],
                'contract_status'=>$data['contract_status'],
//                'stylist_id'=>$data['stylist_id'],
//                'pm_id'=>$data['pm_id'],
//                'supervisor_id'=>$data['supervisor_id'],
                'start_time'=>strtotime($data['start_time']),
                'end_time'=>strtotime($data['end_time']),
                'update_time'=>time(),
            ];
            DB::table('contract')->where('id',$id)->update($date);
            return $this->success('','修改成功') ;
        }else{
            if (!empty($id)){
                $staff = new Staff();
                $list = $project->where('id',$id)->first();
                $list['stylist_name'] = $staff->where('id',$list['stylist_id'])->value('username');//查询职位是否存在
                $list['pm_name'] = $staff->where('id',$list['pm_id'])->value('username');//查询职位是否存在
                $list['supervisor_name'] = $staff->where('id',$list['supervisor_id'])->value('username');//查询职位是否存在
                $list['start_time'] = date('Y-m-d H:i:s',$list['start_time']);
                $list['end_time'] = date('Y-m-d H:i:s',$list['end_time']);
                $where['list'] = $list;

                return view('admin/project/projectEdit',$where);
            }
        }
        return json_encode('参数错误');
    }

    /**
     * 工程信息详情
     * @param $id
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function projectInfo($id){
        $project = new Project();
        if (!empty($id)){
            $staff = new Staff();
            $list = $project->where('id',$id)->first();
            $list['stylist_name'] = $staff->where('id',$list['stylist_id'])->value('username');//查询职位是否存在
            $list['pm_name'] = $staff->where('id',$list['pm_id'])->value('username');//查询职位是否存在
            $list['supervisor_name'] = $staff->where('id',$list['supervisor_id'])->value('username');//查询职位是否存在
            $list['start_time'] = date('Y-m-d H:i:s',$list['start_time']);
            $list['end_time'] = date('Y-m-d H:i:s',$list['end_time']);
            $where['list'] = $list;

            return view('admin/project/projectInfo',$where);
        }
        return json_encode('参数错误');
    }

    /**
     * 工程流程信息
     * @param Request $request
     */
    public function contract_flow(Request $request,$id){
        $contract = new ContractType();
        $list = $contract->where('contract_id',$id)->paginate(10);
        foreach ($list as $k=>$v){
            $list[$k]['acceptance_info'] = mb_substr($v['acceptance_info'], 0, 6, 'utf-8').'...';
            $list[$k]['remark'] = mb_substr($v['remark'], 0, 6, 'utf-8').'...';
            $list[$k]['engineering_inspect'] = mb_substr($v['engineering_inspect'], 0, 6, 'utf-8').'...';
            $list[$k]['inspect_remark'] = mb_substr($v['inspect_remark'], 0, 6, 'utf-8').'...';
        }
        $data['list'] = $list;
        return view('admin/project/contract_flow',$data);
    }

    /**
     * 工程流程新增
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contract_flowAdd(Request $request){
        if ($request->hasFile('upgteimg')){
                    $path = $request->file('upgteimg');
                    $id = array();
                    foreach ($path as $k=>$v){
                        $svename = $v->store('ddimg');
                        $where = [
                            'svename'=>$svename,
                            'sts'=>0
                        ];
                       $ids = DB::table('file')->insertGetId($where);
                       $id[] = $ids;
                    }
            $data = $request->post();
            $data['picture_id'] = implode(",",$id);//图片集
            $data['picture_id']=rtrim($data['picture_id'], ",");
            $list = [
                'contract_id'=>$data['contract_id'],
                'picture_id' =>$data['picture_id'],
                'type'=>$data['type'],
                'remark'=>$data['remark'],
                'engineering_inspect'=>$data['engineering_inspect'],
                'inspect_remark'=>$data['inspect_remark'],
                'acceptance_info'=>$data['acceptance_info'],
                'status'=>$data['status'],
                'patrol_time'=>$data['patrol_time'],
            ];
            $v = DB::table('contract_type')->insertGetId($list);
            if (!empty($v)){
                return $this->success('','添加成功') ;
            }else{
                return$this->error('','添加失败') ;
            }
        }
        return view('admin/project/contract_flowAdd');
    }

    /**
     * 流程编辑
     * @param Request $request
     * @param $id
     * @return array|false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function contractEdit(Request $request,$id){
        $data = $request->post();
        $project = new ContractType();
        if (!empty($data)){
            $date = [
                'status'=>$data['status'],
            ];
            DB::table('contract_type')->where('id',$id)->update($date);
            return $this->success('','修改成功') ;
        }else{
            if (!empty($id)){
                $list = $project->where('id',$id)->first();
                $where['list'] = $list;
                return view('admin/project/contractEdit',$where);
            }
        }
        return json_encode('参数错误');
    }




}