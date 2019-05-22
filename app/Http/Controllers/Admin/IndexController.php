<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/28
 * Time: 16:41
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\UserSite;
use Illuminate\Http\Request;

class IndexController extends AdminController{
    public  function index(){
//        dump(session('admin'));
        return view('admin/index');
    }

}
