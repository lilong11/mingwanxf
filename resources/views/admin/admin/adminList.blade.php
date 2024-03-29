@include('admin.common.header')

<body>
<div class="x-nav">

    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="{{url('admin/adminList')}}" method="post">
            <input style="width: 13em" type="text" name="key"  placeholder="请输入姓名或电话号码" autocomplete="off" class="layui-input">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
        <button class="layui-btn" onclick="x_admin_show('添加职员','{{url('admin/adminAdd')}}',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$list->total()}} 条</span>
    </xblock>
    <table class="layui-table x-admin">
        <thead>
        <tr>
            {{--<th>--}}
                {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            {{--<th>ID</th>--}}
            <th>姓名</th>
            {{--<th>性别</th>--}}
            <th>手机</th>
            <th>邮箱</th>
            <th>所属部门</th>
            <th>职位</th>
            <th>加入时间</th>
            <th>最近登陆</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $v)
        <tr>
            {{--<td>--}}
                {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</td>--}}
            {{--<td>1</td>--}}
            <td>{{$v->real_name}}</td>
            {{--<td></td>--}}
            <td>{{$v->ad_mobile}}</td>
            <td>{{$v->email_address}}</td>
            <td>{{$v->department_name}}</td>
            <td>{{$v->position_name}}</td>
            <td>{{$v->create_time}}</td>
            <td>{{$v->login_time}}</td>
            @if($v->status == 1)
            <td class="td-status">
                在职
            </td>
                @elseif($v->status == -1)
                <td class="td-status">
                    已离职
                    <p>离职时间：{{$v->update_time}}</p>
                </td>
                @elseif($v->status == 2)
                <td class="td-status">
                    申请离职中
                </td>
            @endif
            <td class="td-manage">
                {{--<a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">--}}
                    {{--<i class="layui-icon">&#xe601;</i>--}}
                {{--</a>--}}
                <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/adminEditPage')}}/{{$v->Id}}',600,400)" href="javascript:;">
                    <i class="layui-icon">&#xe642;</i>
                </a>
                {{--<a onclick="x_admin_show('修改密码','member-password.html',600,400)" title="修改密码" href="javascript:;">--}}
                    {{--<i class="layui-icon">&#xe631;</i>--}}
                {{--</a>--}}
                {{--<a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">--}}
                    {{--<i class="layui-icon">&#xe640;</i>--}}
                {{--</a>--}}
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

            if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
            }

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