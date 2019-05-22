@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="post" action="{{'/sectionList'}}">

            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="name"  placeholder="请输入部门名" autocomplete="off" class="layui-input">
            </div>

            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>

        </form>
    </div>
    <xblock>
        <div class="layui-card-header">
            {{--<a href="/sectionAdd">ddd</a>--}}
            <button class="layui-btn" onclick="x_admin_show('添加部门','/sectionAdd')"><i class="layui-icon"></i>添加</button>
        </div>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            {{--<th>--}}
            {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>id</th>
            <th>部门名称</th>
            <th>部门职位</th>
            <th>状态</th>
            <th >操作</th>
        </tr>
        </thead>
        <tbody>

        @foreach($list as $v)

            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>
                    <div style="width: 100%;">
                        @foreach($Plist as $k => $vv)
                            @if( $vv->did == $v->id )
                                {{$vv->position_name}}
                            @endif
                        @endforeach
                        {{--<button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','-adminedit.html')" ><i class="layui-icon">&#xe642;</i>编辑</button>--}}
                    </div>
                </td>
                {{--<td>{{$v->position_name}}</td>--}}

                @if($v->status == 1)
                    <td class="td-payment_status">开启</td>
                @elseif($v->status == 2)
                    <td class="td-payment_status">关闭</td>
                @endif



                <td class="td-manage">
                    <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('编辑','{{'/sectionedit'}}/{{$v->id}}',400,250)" ><i class="layui-icon">&#xe642;</i>修改部门
                    </button>

                    <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('编辑','{{'/positionAdd'}}/{{$v->id}}',400,250)" ><i class="layui-icon">&#xe642;</i>添加职位</button>
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