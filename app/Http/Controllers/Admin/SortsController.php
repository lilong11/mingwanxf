<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/2
 * Time: 14:18
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSite;
use Illuminate\Http\Request;
class SortsController extends AdminController{

    /*
    * 装修类型
    * */
    public function siteType(Request $request){
        $userSite = new UserSite();
        if ($request->isMethod('post')){
            $type =  $request->post('type');
//            exit($type);
            $data = [
                'status' => 1,
                'us_type' =>trim($type),
            ];
            try{
                $userSite->insert($data);
                return $this->success('','添加成功');
            }catch (\Exception $e){
                return $this->error($e->getMessage(),'添加失败');
            }
        }
        $siteList = $userSite->select()->paginate(15);
//        dump($siteList);
        $data['type'] = $siteList;
        return view('admin/siteType',$data);
    }

    public function siteStop($id){
        if (!empty($id)){
//            dump($id);
            $userSite = new UserSite();
            $data = [
                'status' => -1,
            ];
            try{
                $userSite->where('Id',$id)->update($data);
                return $this->success('','已禁用');
            }catch (\Exception $e){
                return $this->error('','无法禁用');
            }
        }
        return $this->error('','参数不能为空');
    }

    public function siteStart($id){
        if (!empty($id)){
//            dump($id);
            $userSite = new UserSite();
            $data = [
                'status' => 1,
            ];
            try{
                $userSite->where('Id',$id)->update($data);
                return $this->success('','已启用');
            }catch (\Exception $e){
                return $this->error('','无法启用');
            }
        }
        return $this->error('','参数不能为空');
    }
}