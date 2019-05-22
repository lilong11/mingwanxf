<?php
/**
 * Created by PhpStorm.
 * User: boye
 * Date: 2018/5/10
 * Time: 18:33
 */

namespace App\Http\Logic;
use Illuminate\Database\Eloquent\Builder;

 class Logic
{
    /**
     * 返回成功
     * @param $info
     * @param string $msg
     * @param int $code
     * @return array
     */
     public function success($info, $msg = 'ok', $code = 0)
    {
        return [
            'code' => $code,
            'info' => $info,
            'msg' => $msg
        ];
    }

    /**
     * 返回失败
     * @param $info
     * @param string $msg
     * @param int $code
     * @return array
     */
    public function error($info, $msg = 'error', $code = -1)
    {
        return [
            'code' => $code,
            'info' => $info,
            'msg' => $msg
        ];
    }

    /**
     * 分页
     * @param Builder $builder
     * @param array $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function query(Builder $builder, $page = [])
    {
        $perPage     = isset($page['perPage']) ? $page['perPage'] : 15;
        $currentPage = isset($page['currentPage']) ? $page['currentPage'] : 1;
        $columns     = isset($page['columns']) ? $page['columns'] : ['*'];
        $pageName    = isset($page['pageName']) ? $page['pageName'] : 'page';
        return $builder->paginate($perPage, $columns, $pageName, $currentPage);
    }
}