<?php
/**
 * Created by PhpStorm.
 * User: boye
 * Date: 2018/5/10
 * Time: 18:54
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 生成分页html
     * @param $array
     * @return string
     */
    protected function buildPages($array)
    {
        $pages = '';
        if (!is_null($array['prev_page_url'])) {
            $pages = '<a class="prev" href="'.$array['prev_page_url'].'">&lt;&lt;</a>';
        } else {
            $pages = '<a class="prev" href="javascript:void(0);">&lt;&lt;</a>';
        }
        $pages .= '<a class="num" href="javascript:void(0);">'.$array['current_page'].'</a>';
        if (!is_null($array['next_page_url'])) {
            $pages .= '<a class="next" href="'.$array['next_page_url'].'">&gt;&gt;</a>';
        } else {
            $pages .= '<a class="next" href="javascript:void(0);">&gt;&gt;</a>';
        }
        return $pages;
    }
    /**
     * 返回成功
     * @param $info
     * @param string $msg
     * @param int $code
     * @return array
     */
    protected function success($info, $msg = 'ok', $code = 0)
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
    protected function error($info, $msg = 'error', $code = -1)
    {
        return [
            'code' => $code,
            'info' => $info,
            'msg' => $msg
        ];
    }

    /**
     * 图片上传
     * @param Request $request
     * @return array
     */
    public function picUpload($PicFile)
    {
        $file = $PicFile;
        $pathname = $file->path();
        $fileContent = file_get_contents($pathname);
        $filetype = $file->getClientOriginalExtension();
//        return $filetype;
        $fileDir = public_path() . '/uploads/' . date('Y');
        if (!is_dir($fileDir)){
            mkdir($fileDir);
        }
        $fileDir .= '/' . date('m');
        if (!is_dir($fileDir)) {
            mkdir($fileDir);
        }
        $filename = date('YmdHis') . substr(md5($fileContent), 0, 5).'.'.$filetype;
        $fileDir .= '/' . $filename;
        copy($pathname, $fileDir);
        unlink($pathname);
        $info = [
            'path' => '/uploads/' . date('Y') . '/' . date('m') . '/' . $filename
        ];
        return $info;
    }



}