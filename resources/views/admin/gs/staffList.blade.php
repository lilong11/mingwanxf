@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="post" action="{{url('admin/staffList')}}">

            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
            </div>

            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="phone"  placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>

            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>

        </form>
    </div>
    <xblock>
    <div class="layui-card-header">
        <button class="layui-btn" onclick="x_admin_show('添加职员','/staffAdd')"><i class="layui-icon"></i>添加</button>
    </div>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            {{--<th>--}}
            {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>id</th>
            <th>姓名</th>
            <th>手机号</th>
            <th>邮箱地址</th>
            <th>性别</th>
            <th>年龄</th>
            <th>部门</th>
            <th>职位</th>
            <th>在职状态</th>
            <th >操作</th>
        </tr>
        </thead>
        <tbody>

        @foreach($list as $v)

            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->username}}</td>
                <td>{{$v->phone}}</td>
                <td>{{$v->email}}</td>

                @if($v->sex == 1)
                    <td class="td-payment_status">男</td>
                @elseif($v->sex == 2)
                    <td class="td-payment_status">女</td>
                @endif


                <td>{{$v->age}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->position_name}}</td>

                @if($v->status == 1)
                    <td class="td-payment_status">在职</td>
                @elseif($v->status == 2)
                    <td class="td-payment_status">停职</td>
                @elseif($v->status == 3)
                    <td class="td-payment_status">离职</td>
                @elseif($v->status == 4)
                    <td class="td-payment_status">请假</td>
                @endif



                <td class="td-manage">
                    <a title="编辑"  onclick="x_admin_show('编辑','{{'/staffedit'}}/{{$v->id}}')" href="javascript:;">
                        <i class="layui-icon">&#xe642;</i>
                    </a>

                    <a title="删除" onclick="staff_del(this,{{$v->id}})" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="layui-card-body ">
    <div class="page">
        <div>

            {{  $list->links()  }}

        </div>
    </div>
</div>
{{--<script type="text/javascript" src="/static/lib/layui/layui.js"></script>--}}
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

    /*用户-删除*/
    function staff_del(obj,id){
        layer.confirm('确认要将该职员删除吗？',function(index){
            //发异步删除数据
            $.ajax({
                url:'{{url('admin/staDelete')}}/'+ id,
                type:'get',
                dataType:'json',
                success:function (data) {
                    console.log(data);
                    if (data.code  < 0){
                        layer.msg(data.msg,{icon:1,time:1000});
                    }else{
                        layer.msg(data.msg,{icon:1,time:1000});
                        $(obj).parents("tr").find(".td-status").html('已取消');
                    }
                }
            });
        });
    }




    function delAll (argument){

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
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