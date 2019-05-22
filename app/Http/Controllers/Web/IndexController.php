<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/28
 * Time: 18:29
 */
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOrder;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Models\UserSite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;


class IndexController extends AdminController{

    public function index(Request $request){

        if ($request->isMethod('post')){
//            $urlTest =URL::current();
//            return $urlTest;
            $data = $request->post();
//            dump($data);
            $check = $this->data_check($data);
            if ($check['status'] == -1){
                return $this->error('',$check['info']);
            }
            $user = new User();
            $id = $user->select('Id')->where('mobile_number','=',$data['mobile'])->first();
//            exit($id);
//            date_default_timezone_set("Asia/Shanghai");
            $now = date('Y-m-d h:i:s',time());
            if ($id == null){
                DB::beginTransaction();
                try{
                    $user_data = [
                        'user_name' => $data['name'],
                        'mobile_number' =>$data['mobile'],
                        'approach_id' =>$data['approach'],
                        'create_time'=> $now,
                        'status'=>1
                    ];
                    $userId =  $user->insertGetId($user_data);
//                $userId = $user->id;
//                dump($userId);
                    $order_data = [
                        'user_id' =>$userId,
                        'status' => -1,
                        'interior_area'=>$data['area'],
                        'site_id'=>$data['site'],
                        'create_time'=> $now,
                        'payment_status' => -1
                    ];
//                dump($order_data);
                    $userOrder = new UserOrder();
                    $userOrder->insert($order_data);
                    DB::commit();
                    return $this->success('','添加成功');
                }catch (\Exception $e){
                    DB::rollBack();
                    return $this->error($e->getMessage(),'添加失败');
                }
            }else{
//                exit($id);
                try{
                    $order_data = [
                        'user_id' =>$id['Id'],
                        'status' => -1,
                        'interior_area'=>$data['area'],
                        'site_id'=>$data['site'],
                        'create_time'=> $now,
                        'payment_status' => -1
                    ];
//                dump($order_data);
                    $userOrder = new UserOrder();
                    $userOrder->insert($order_data);
                    return $this->success('','添加成功');
                }catch (\Exception $e){
                    return $this->error($e->getMessage(),'添加失败');
                }
            }
        }
        $userSite = new UserSite();
        $siteList = $userSite->get()->where('status','=','1');
//        dump($siteList);
        $data['type'] = $siteList;
        return view('web/form',$data);
    }
    protected function data_check($data){
        if(empty($data['mobile']) || preg_match('/^1[0-9]\d{9}$/',$data['mobile']) == false){
            return $list=  ['status' => -1,'info'=>'手机号码信息错误'];
        }
        if (empty($data['name']) || strlen($data['name']) > 12){
            return $list=  ['status' => -1,'info'=>'姓名信息错误'];
        }
        if(empty($data['approach']) || preg_match('/^[1-9][0-9]*$/',$data['approach']) == false){
            return $list=  ['status' => -1,'info'=>'非法信息输入'];
        }
//        if(empty($data['site']) || preg_match('/^[1-9][0-9]*$/',$data['site']) == false){
//            return $list=  ['status' => -1,'info'=>'非法信息输入'];
//        }
        return $list=  ['status' => 1];
    }
}
