<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/29
 * Time: 9:23
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class AdminDepartment extends Model{
    protected $table = 'admin_department';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['status','department_name'];
}
