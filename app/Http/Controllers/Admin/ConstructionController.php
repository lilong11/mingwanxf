<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/26
 * Time: 16:52
 */
namespace App\Http\Controllers\Admin;

use App\Http\Logic\ConstructionLogic;
use App\Models\AdminInformation;
use App\Models\AdminPosition;
use App\Models\User;
use App\Models\UserOrderDecoration;
use Illuminate\Http\Request;

class ConstructionController extends AdminController{
    private $viewUrl = 'admin/construction/';

    /*
     * 工程列表
     * */
    public function Index(Request $request){
        $key = '';
        if (!empty($request->post('status'))){
            $key = $request->post('status');
        }
        $list = (new ConstructionLogic())->queryWithPage($key);
        $data = ['list'=>$list];
        return view($this->viewUrl.'index',$data);
    }

    /*
     * 工程详情表单
     * */
    public function detailInformationList($id){
//        dump($id);
        if (empty($id)){
            return $this->error('','重要参数错误');
        }
        $info = (new ConstructionLogic())->queryInfoNotPage($id);
        $data = ['info' => $info];
        return view($this->viewUrl.'decorationDetailInfo',$data);
    }

    /*
     * 详情编辑页
     * */
    public function decorationInformationEditPage($id)
    {
        $info = (new ConstructionLogic())->queryInfoNotPage($id);

        $infoName =$info[0];
//        //各职位的职员名单列表
        $managerList = $this->queryAdminList('项目经理');
        $designer = $this->queryAdminList('设计师');
        $supervisor = $this->queryAdminList('监理');
        $infoName['manager_list']=$managerList;
        $infoName['designer_list']=$designer;
        $infoName['supervisor_list']=$supervisor;
        $data = ['info'=>$info];
        return view($this->viewUrl.'decorationInfoEdit',$data);
    }
    private function queryAdminList($data){
        $adminPosition = new AdminPosition();
        $list = $adminPosition->where('position_name',$data)->join('admin_information','position_id','=','admin_position.Id')->select('real_name','admin_information.Id')->get();
        return $list;
    }

    /*
     * 详情编辑
     * */
    public function decorationInformationEdit(Request $request)
    {
        if($request->isMethod('post')){
            dump($request->post());
        }
    }

}