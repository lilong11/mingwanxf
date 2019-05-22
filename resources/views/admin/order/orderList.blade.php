@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="post" action="{{url('admin/orderList')}}">

            <div class="layui-input-inline">
                <select name="pay_status">
                    <option value="">支付状态</option>
                    <option value="1">已支付</option>
                    <option value="-1">未支付</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="status">
                    <option value="">订单状态</option>
                    <option value="-1">未完成</option>
                    <option value="1">已完成</option>
                    <option value="-2">已取消</option>
                </select>
            </div>

            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
    </div>
    <xblock>

        <span class="x-right" style="line-height:40px">共有数据：{{$list->total()}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            {{--<th>--}}
                {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>订单编号</th>
            <th>用户姓名</th>
            <th>用户手机号</th>
            <th>装修面积</th>
            <th>装修类型</th>
            <th>支付状态</th>
            <th>订单状态</th>
            <th>下单时间</th>
            <th>工程状态</th>
            <th >操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $v)
        <tr>
            {{--<td>--}}
                {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->Id}}'><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</td>--}}
            <td>{{$v->Id}}</td>
            <td>{{$v->user_name}}</td>
            <td>{{$v->mobile_number}}</td>
            <td>{{$v->interior_area}}平方米</td>
            <td>{{$v->us_type}}</td>
            @if($v->payment_status == -1)
                <td class="td-payment_status">未支付</td>
            @elseif($v->payment_status == 1)
                <td class="td-payment_status">已支付</td>
            @endif
            @if($v->status == -1)
                <td class="td-status">未完成</td>
            @elseif($v->status == 1)
                <td class="td-status">已完成</td>
            @elseif($v->status == -2)
                <td class="td-status">已取消</td>
            @endif
            <td>{{$v->create_time}}</td>
            <td>
                <span class="layui-btn  layui-btn-xs" onclick="x_admin_show('装修状态编辑','{{url('admin/decorationEditPage')}}/{{$v->Id}}')" href="javascript:;">编辑</span>
            </td>
            <td class="td-manage">
                {{--<a title="编辑查看"  onclick="x_admin_show('编辑','{{$v->Id}}')" href="javascript:;">--}}
                    {{--<i class="layui-icon">&#xe63c;</i>--}}
                {{--</a>--}}
                @if($v->status != -2)
                <a title="取消订单" onclick="order_del(this,'{{$v->Id}}')" href="javascript:;">
                    <i class="layui-icon">&#xe640;</i>
                </a>
                @endif
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
                $(obj).attr('title','停用');
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','启用');
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