@include('admin.common.header')
<style>
    /*.title th{*/
        /*font-size: 10px;*/
        /*color: #000;*/
    /*}*/
    /*.listInfo td{*/
        /*font-size: 10px;*/
        /*color: #000;*/
    /*}*/
</style>
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="post" action="{{url('admin/ConstructIndex')}}">
            {{--<div class="layui-input-inline">--}}
                {{--<select name="pay_status">--}}
                    {{--<option>支付状态</option>--}}
                    {{--<option value="1">已支付</option>--}}
                    {{--<option value="-1">未支付</option>--}}
                {{--</select>--}}
            {{--</div>--}}
            <div class="layui-input-inline">
                <select name="status">
                    <option value="">装修状态</option>
                    <option value="-1">待开工</option>
                    <option value="1">在建工地</option>
                    <option value="2">已竣工</option>
                </select>
            </div>
            <button class="layui-btn"  lay-submit="" lay-filter="search"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>
        <span class="x-right" style="line-height:40px">共有数据：{{$list->total()}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr class="title">
            {{--<th>--}}
            {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>合同编号</th>
            <th>工程名称</th>
            {{--<th>用户姓名</th>--}}
            {{--<th>用户手机号</th>--}}
            {{--<th>工程地址</th>--}}
            {{--<th>装修面积</th>--}}
            {{--<th>装修类型</th>--}}
            <th>装修状态</th>
            <th>设计师</th>
            <th>项目经理</th>
            <th>监理</th>
            <th>流程状态</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>详情</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $v)
            <tr class="listInfo">
                {{--<td>--}}
                {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->Id}}'><i class="layui-icon">&#xe605;</i></div>--}}
                {{--</td>--}}
                <td>{{$v->contract_number}}</td>
                <td>{{$v->project_name}}</td>
                {{--<td>{{$v->user_name}}</td>--}}
                {{--<td>{{$v->mobile_number}}</td>--}}
                {{--<td>{{$v->project_address}}</td>--}}
                {{--<td>{{$v->interior_area}}平方米</td>--}}
                {{--<td></td>--}}
                <td>
                    @if($v->decoration_status == -1)
                        未开工
                        @elseif($v->decoration_status == 2)
                        竣工
                        @else
                        在建工地
                    @endif
                </td>
                <td>{{$v->designer}}</td>
                <td>{{$v->manager}}</td>
                <td>{{$v->supervision}}</td>
                <td>
                    <span class="layui-btn  layui-btn-xs" onclick="x_admin_show('流程状态编辑','{{url('admin/')}}/{{$v->Id}}')" href="javascript:;">编辑</span>
                </td>
                <td>
                    @if($v->start_time)
                    {{$v->start_time}}
                        @else
                        无
                    @endif
                </td>
                <td>
                    @if($v->end_time)
                        {{$v->end_time}}
                    @else
                        无
                    @endif
                    {{--{{$v->end_time}}--}}
                </td>
                <td>
                    <a href="{{url('admin/detailInformation')}}/{{$v->Id}}">
                        <span class="layui-btn  layui-btn-xs" href="">详情</span>
                    </a>
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
    function order_del(obj,id){
        layer.confirm('确认要将订单取消吗？',function(index){
            //发异步删除数据
            $.ajax({
                url:'{{url('admin/orderDelete')}}/'+ id,
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