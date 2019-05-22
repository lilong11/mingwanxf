<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/18
 * Time: 10:01
 */
namespace App\Http\Logic;

use App\Models\WxUser;

class MemberLogic extends Logic{
    public function queryWithPage($key)
    {
        $where = [];
//        dump($key);
        if (!empty($key)){
            $where[] = ['nickname','like',"%$key%"];
        }
        try{
            $wxUser = new WxUser();
            $list = $wxUser->where($where)->select('Id','nickname','last_login_time','avatar','create_time','status','openid')->paginate(15);
//            $test = $list[0]['nickname'];
            foreach ($list as $k => $v){
//                dump($v['nickname']);
                $list[$k]['nickname'] = urldecode($v['nickname']);
            }
//            dump($list);
//            dump($test);
            return $this->success($list);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),'查询错误');
        }
    }


}
