<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/29
 * Time: 9:21
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminInformation extends Model{
    protected $table = 'admin_information';
    public $timestamps = false;
    public $fillable = ['real_name','ad_mobile','ad_password','position_id','login_time','create_time','update_time','status','email_address'];
}

