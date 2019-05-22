<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>会员申请</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/admin/css/font.css">
    <link rel="stylesheet" href="/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/admin/js/xadmin.js"></script>

</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
<div class="x-body" onsubmit="false">
    <form class="layui-form" method="post" action="{{url('wxForm')}}">
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label" for="type">--}}
                {{--<span class="x-red">*</span>装修面积：--}}
            {{--</label>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<span class="select-box">--}}
				{{--<select name="area" class="select" id="area">--}}
					{{--<option value="0">室内面积</option>--}}
                    {{--<option value="10-50">10-50</option>--}}
                    {{--<option value="50-150">50-150</option>--}}
                    {{--<option value="150-300">150-300</option>--}}
                    {{--<option value="300-500">300-500</option>--}}
                    {{--<option value="500-1000">500-1000</option>--}}
                    {{--<option value="1000-3000">1000-3000</option>--}}
                    {{--<option value="3000以上">3000以上</option>--}}
				{{--</select>--}}
				{{--</span>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label" for="type">--}}
                {{--<span class="x-red">*</span>装修类型：--}}
            {{--</label>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<span class="select-box">--}}
				{{--<select name="site" class="select" id="type">--}}
					{{--<option value="0">装修类型</option>--}}
                    {{--@foreach ($type as $vv)--}}
                    {{--<option value="{{$vv->Id}}">{{$vv->us_type}}</option>--}}
                    {{--@endforeach--}}
				{{--</select>--}}
				{{--</span>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>姓名：
            </label>
            <div class="layui-input-inline">
                <input type="text" id="name" name="name" required lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>请输入您的姓名
            </div>
        </div>

        <div class="layui-form-item">
            <label for="title" class="layui-form-label">
                <span class="x-red">*</span>电话：
            </label>
            <div class="layui-input-inline">
                <input type="number" id="mobile" name="mobile" required lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>请输入您的电话号码
            </div>
        </div>
        <input type="number" style="display: none" id="approach" value="2" name="approach" required lay-verify="required" autocomplete="off" class="layui-input">
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-submit type="button" id="addBtn" lay-filter="add" >
                提交
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $(function (){
        function getUrlParam(name){
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var param = window.location.search.substr(1).match(reg);
            if (param == null){
                return null;
            }
            return param[2];
        }
        var admin = getUrlParam('adminId');
        var openid = getUrlParam('openId');
        layui.use('form', function (){
            var form = layui.form;
            //监听提交
            form.on('submit(add)', function (data){
                var dataForm = data.field;
                // dataForm.push();
                dataForm['openid'] = openid;
                dataForm['adminId'] = admin;
                // console.log(dataForm);
                // return false;
                $(data.elem).addClass('layui-btn-disabled');
                var layer_id = layer.msg('正在努力加载中//~~');
                $.post({
                    url: data.form.action,
                    data: data.field,
                    success: function (res){
                        $(data.elem).removeClass('layui-btn-disabled');
                        layer.close(layer_id);
                        if (res.code == 0){
                            layer.msg(res.msg, function (){
                                window.location.reload();
                            });
                        } else {
                            layer.msg(res.msg);
                        }
                    }
                });
                return false;
            });
        });
    })

</script>
