<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/10
 * Time: 15:43
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    public $timestamps = false;
    //模型操作主键名称
//    public $primarykey = 'pid';
    public $fillable = ['username','phone','pid','create_time','update_time','status','email','sex','age'];



    public function position(){
        return $this->hasOne('App\Models\Position', 'id','pid');
    }

    public function section(){
        return $this->hasMany('App\Section','id');
    }

}