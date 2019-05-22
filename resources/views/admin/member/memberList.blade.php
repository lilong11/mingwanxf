@extends('admin.common.header')

<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="{{url('admin/memberList')}}" method="post">
            {{--<input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start">--}}
            {{--<input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end">--}}
            <input type="text" name="keyWord"  placeholder="请输入用户手机号码" autocomplete="off" class="layui-input">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量禁用</button>
        {{--<button class="layui-btn" onclick="x_admin_show('添加用户','./member-add.html',600,400)"><i class="layui-icon"></i>添加</button>--}}
        <span class="x-right" style="line-height:40px">共有数据：{{$list->total()}}条</span>
    </xblock>
    <table class="layui-table x-admin">
        <thead>
        <tr>
            <th>
                <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>姓名</th>
            <th>手机</th>
            <th>加入时间</th>
            <th>加入渠道</th>
            <th>会员等级</th>
            <th>状态</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
        @foreach($list as $v)
        <tr>

            <td>
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->Id}}'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{$v->Id}}</td>
            <td><a onclick="x_admin_show('订单列表','{{url('admin/memberOrder')}}/{{$v->Id}}',)">{{$v->user_name}}</a></td>
            <td>{{$v->mobile_number}}</td>
            <td>{{$v->create_time}}</td>
            <td>
                {{$v->ua_type}}
                @if($v->approach_id == 2)
                    <p style="color: #000; font-size: 12px;">推荐人：{{$v->real_name}}</p>
                @endif
            </td>
            @if($v->grade == 1)
            <td>访客</td>
            @elseif($v->grade == 2)
                <td>优惠会员</td>
            @endif
            <td class="td-status">
                @if($v->status == 1)
                <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                @elseif($v->status == -1)
                    <span class="layui-btn layui-btn-disabled layui-btn-mini">已禁用</span>
                @endif
            </td>
            <td class="td-manage">
                @if($v->status == 1)
                <span class="layui-btn layui-btn-danger layui-btn-mini" onclick="member_stop(this,{{$v->Id}})" href="javascript:;">禁用</span>
                @elseif($v->status == -1)
                    <span class="layui-btn layui-btn-normal layui-btn-mini" onclick="member_start(this,{{$v->Id}})" href="javascript:;">启用</span>
                    @endif
                {{--<span class="layui-btn layui-btn-normal layui-btn-mini" onclick="x_admin_show('编辑','{{url('admin/memberEdit')}}/{{$v->Id}}')" href="javascript:;">编辑</span>--}}
            </td>

        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="page">
        <div>
            {{$list->links()}}
        </div>
    </div>

</div>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

    /*用户-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            $.ajax({
                url:'{{url('admin/memberStop')}}/'+id,
                type:'get',
                dataType:'json',
                success:function (data) {
                    if (data.code < 0){
                        layer.msg(data.msg,{icon:1,time:1000});
                    } else {
                        layer.msg(data.msg,{icon:1,time:1000});
                        $(obj).parents('tr').find(".td-status").find('span').removeClass('layui-btn-normal').addClass('layui-btn-disabled').html('已禁用');
                        $(obj).parents('tr').find(".td-manage").find('span:first-child').removeClass('layui-btn-danger').addClass('layui-btn-disabled').html('已禁用');
                    }
                }
            });
        });
    }
    /*用户-启用*/
    function member_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            $.ajax({
                url:'{{url('admin/memberStart')}}/'+id,
                type:'get',
                dataType:'json',
                success:function (data) {
                    if (data.code < 0){
                        layer.msg(data.msg,{icon:1,time:1000});
                    } else {
                        layer.msg(data.msg,{icon:1,time:1000});
                        $(obj).parents('tr').find(".td-status").find('span').removeClass('layui-btn-disabled').addClass('layui-btn-normal').html('已启用');
                        $(obj).parents('tr').find(".td-manage").find('span:first-child').removeClass('layui-btn-normal').addClass('layui-btn-disabled').html('已启用');
                    }
                }
            });
        });
    }

    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }



    function delAll (argument) {
        var data = tableCheck.getData();
        var ids = '';
        // console.log(data);
        $.each(data,function (k,v) {
           if (v != ''){
               ids += v + ',';
           }
        });
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            $.ajax({
                url:'{{url('admin/memberStop')}}/'+ids,
                type:'get',
                dataType:'json',
                success:function (data) {
                    if (data.code < 0){
                        layer.msg(data.msg,{icon:1,time:1000});
                    } else {
                        layer.msg(data.msg,{icon:1,time:1000});
                        $('.layui-form-checked').not('.header').parents('tr').find(".td-status").find('span').removeClass('layui-btn-normal').addClass('layui-btn-disabled').html('已禁用');
                        $('.layui-form-checked').not('.header').parents('tr').find(".td-manage").find('span:first-child').removeClass('layui-btn-danger').addClass('layui-btn-disabled').html('已禁用');
                    }
                }
            });
        });
    }
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>