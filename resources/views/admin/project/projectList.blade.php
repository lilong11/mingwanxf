@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="post" action="{{'/projectList'}}">

            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="client_name"  placeholder="请输入姓名" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="client_phone"  placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>

            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>

        </form>
    </div>
    <xblock>
        <div class="layui-card-header">

            <a href="/projectAdd" class="layui-btn" ><i class="layui-icon"></i>添加</a>
        </div>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th>工程id</th>
            <th>工程名称</th>
            <th>客户姓名</th>
            <th>客户手机号</th>
            <th>面积</th>
            <th>验收结果</th>
            <th>工程状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

        @foreach($list as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td><a style="color:red" href="/contract_flow/{{$v->id}}"><i class="layui-icon"></i>{{$v->contract_name}}</a></td>
                <td>{{$v->client_name}}</td>
                <td>{{$v->client_phone}}</td>
                <td>{{$v->acreage}}</td>
                @if($v->troa == 1)
                    <td class="td-payment_status">施工中</td>
                @elseif($v->troa == 2)
                    <td class="td-payment_status">通过</td>
                @elseif($v->troa == 3)
                    <td class="td-payment_status">不通过</td>
                @endif

                @if($v->contract_status == 1)
                    <td class="td-payment_status">待开工</td>
                @elseif($v->contract_status == 2)
                    <td class="td-payment_status">在建工地</td>
                @elseif($v->contract_status == 3)
                    <td class="td-payment_status">竣工</td>
                @endif


                <td class="td-manage">
                    <a href="/projectEdit/{{$v->id}}"><i class="layui-icon"></i>修改
                    </a>
                    <a href="/projectInfo/{{$v->id}}"><i class="layui-icon"></i>详情
                    </a>
                    {{--<a href="/projectAdd" class="layui-btn" ><i class="layui-icon"></i>添加</a>--}}
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