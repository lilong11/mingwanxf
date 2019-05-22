<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/29
 * Time: 9:30
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSite extends Model{
    protected $table = 'user_site';
    public $timestamps = false;
    protected $fillable = ['status','type'];
}
