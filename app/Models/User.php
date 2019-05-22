<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/29
 * Time: 9:26
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model{
    protected $table = 'user';
    public  $timestamps = false;
    protected $fillable = ['user_name','mobile_number','approach_id','create_time','update_time','status','grade','wx_openid'];
}
