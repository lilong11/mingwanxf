<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/1
 * Time: 9:02
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UserOrder extends Model{
    protected $table = 'user_order';
    public $timestamps = false;
    protected $fillable = ['user_id','interior_area','site_id','status','create_time','update_time','payment_status'];

    public static function withCount(array $array)
    {
    }

    public function userSite(){
        return $this->hasOne('App\UserSite', 'user_id', 'id');
}
}