@include('admin.common.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body" onsubmit="false">
    <div class="layui-row">
    <form class="layui-form" method="post" action='{{url('admin/site')}}'>

        <div class="layui-form-item">
            <label for="name" class="layui-form-label">
                <span class="x-red">*</span>装修类型：
            </label>
            <div class="layui-input-inline">
                <input type="text" id="type" name="type" required lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <button  class="layui-btn" lay-submit type="button" id="addBtn" lay-filter="add" >
                增加
            </button>
        </div>

    </form>
    </div>
<xblock>
    {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
    {{--<button class="layui-btn" onclick="x_admin_show('添加用户','./member-add.html',600,400)"><i class="layui-icon"></i>添加</button>--}}
    <span class="x-right" style="line-height:40px">共有数据：{{$type->total()}} 条</span>
</xblock>
<table class="layui-table x-admin">
    <thead>
    <tr>
        <th>房屋使用类型</th>
        <th>状态</th>
        <th>操作</th></tr>
    </thead>
    <tbody>
    @foreach($type as $v)
    <tr>
        <td>{{$v->us_type}}</td>
        @if($v->status == 1)
        <td class="td-status">
            <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
        </td>
        @else
            <td class="td-status">
                <span class="layui-btn layui-btn-disabled layui-btn-mini">已禁用</span>
            </td>
        @endif
        @if($v->status == -1)
        <td class="td-manage">
            <a onclick="sort_start(this,'{{$v->Id}}')" href="javascript:;"  title="启用">
                <i class="layui-icon">&#xe601;</i>
            </a>
        </td>
            @elseif($v->status == 1)
            <td class="td-manage">
                <a onclick="sort_stop(this,'{{$v->Id}}')" href="javascript:;"  title="禁用">
                    <i class="layui-icon">&#xe601;</i>
                </a>
            </td>
            @endif
    </tr>
        @endforeach
    </tbody>
</table>
<div class="page">
    <div>
        {{$type->links()}}
    </div>
</div>
</div>

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $(function () {
        layui.use('form', function () {
            var form = layui.form;
            //监听提交
            form.on('submit(add)', function (data) {
                // console.log('qqq');
                $(data.elem).addClass('layui-btn-disabled');
                var layer_id = layer.msg('正在努力加载中//~~');
                $.post({
                    url: data.form.action,
                    data: data.field,
                    success: function (res) {
                        $(data.elem).removeClass('layui-btn-disabled');
                        layer.close(layer_id);
                        // console.log(res);
                        // return false;
                        if (res.code == 0) {
                            layer.msg('添加成功', function () {
                                // var index = layer.getFrameIndex(window.name);
                                //关闭当前frame
                                // layer.close(index);
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
    });

    /*用户-停用*/
    function sort_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            $.ajax({
                url: '{{url('admin/siteStop')}}/'+ id,
                type:'get',
                dataType:'json',
                success:function (data) {
                    if (data.code < 0) {
                        layer.msg(data.msg,{icon:1,time:1000});
                    }else {
                        // console.log(data);
                        layer.msg(data.msg,{icon:1,time:1000});
                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已禁用');

                    }
                }
            });
        });
    }

    /*用户-停用*/
    function sort_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            $.ajax({
                url: '{{url('admin/siteStart')}}/'+ id,
                type:'get',
                dataType:'json',
                success:function (data) {
                    if (data.code < 0) {
                        layer.msg(data.msg,{icon:1,time:1000});
                    }else {
                        // console.log(data);
                        layer.msg(data.msg,{icon:1,time:1000});
                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').addClass('layui-btn-normal').html('已启用');

                    }
                }
            });
        });
    }


</script>
