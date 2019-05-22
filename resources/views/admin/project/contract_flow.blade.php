@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <xblock>
        <div class="layui-card-header">
            <a href="/contract_flowAdd" class="layui-btn" ><i class="layui-icon"></i>添加</a>
        </div>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>工程流程</th>
            <th>备注</th>
            <th>工程巡查</th>
            <th>巡查备注</th>
            <th>巡查时间</th>
            <th>验收情况</th>
            <th>验收详情</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

        @foreach($list as $v)
            <tr>
                <td>{{$v->type}}</td>
                @if($v->type == 1)
                    <td class="td-payment_status">开工形象</td>
                @elseif($v->type == 2)
                    <td class="td-payment_status">水电阶段</td>
                @elseif($v->type == 3)
                    <td class="td-payment_status">泥工阶段</td>
                @elseif($v->type == 4)
                    <td class="td-payment_status">木工阶段</td>
                @elseif($v->type == 5)
                    <td class="td-payment_status">油漆阶段</td>
                @elseif($v->type == 6)
                    <td class="td-payment_status">安装阶段</td>
                @elseif($v->type == 6)
                    <td class="td-payment_status">交付验收</td>
                @endif

                <td>{{$v->remark}}</td>
                <td>{{$v->engineering_inspect}}</td>
                <td>{{$v->remark}}</td>
                <td>{{$v->patrol_time}}</td>
                @if($v->status == 1)
                    <td class="td-payment_status">施工中</td>
                @elseif($v->status == 2)
                    <td class="td-payment_status">通过</td>
                @elseif($v->status == 3)
                    <td class="td-payment_status">不通过</td>
                @endif
                <td>{{$v->acceptance_info}}</td>

                <td class="td-manage">
                    <a href="/contractEdit/{{$v->id}}"><i class="layui-icon"></i>修改
                    </a>
                    {{--<a href="/projectInfo/{{$v->id}}"><i class="layui-icon"></i>详情--}}
                    {{--</a>--}}
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
    })();
</script>

<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#test1' //指定元素
        });
    });
</script>

</body>

</html>