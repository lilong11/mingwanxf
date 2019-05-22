<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/17
 * Time: 14:51
 */
namespace App\Models;
 use Illuminate\Database\Eloquent\Model;

 class WxUser extends Model{
     protected $table = 'wx_user';
     public $timestamps = false;
     protected $fillable = ['Id','openid','nickname','avatar','status','create_time','last_login_time'];
//     public $incrementing = false;
 }