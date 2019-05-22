<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/3
 * Time: 16:16
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdminPosition extends Model{
    protected $table = 'admin_position';
    public $timestamps = false;
    public $fillable = ['position_name','department_name','status'];
}