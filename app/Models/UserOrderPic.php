<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/15
 * Time: 16:51
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderPic extends Model{
    protected $table = 'user_order_pic';
    public $timestamps = false;
    public $fillable = ['pic_url','order_id','create_time','update_time'];
}