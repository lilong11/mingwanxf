<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/30
 * Time: 11:00
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserOrderDecoration extends Model{
    protected $table = 'user_order_decoration';
    public $timestamps = false;
    protected $fillable = ['Id','contract_number','order_id','project_address','project_name','start_time','end_time','decoration_status','acceptance_status','designer_id','manager_id','supervision_id','acceptance_sheet'];
}