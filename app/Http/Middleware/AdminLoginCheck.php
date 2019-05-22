<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 13:46
 */
namespace App\Http\Middleware;


use Closure;

class AdminLoginCheck{

        public function handle($request, Closure $next)
        {
            // 执行动作
            if(session('admin')==''){
                return redirect('admin/login');
            }

            return $next($request);
        }

}