@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        {{--<form class="layui-form layui-col-md12 x-so" action="{{url('admin/memberOrder')}}/{{$id}}" method="post">--}}
            {{--<input class="layui-input" placeholder="开始日" name="start" id="start">--}}
            {{--<input class="layui-input" placeholder="截止日" name="end" id="end">--}}
            {{--<div class="layui-input-inline">--}}
                     {{--<select name="contrller">--}}
                    {{--<option>支付状态</option>--}}
                    {{--<option>已支付</option>--}}
                    {{--<option>未支付</option>--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<select name="contrller">--}}
                    {{--<option>支付方式</option>--}}
                    {{--<option>支付宝</option>--}}
                    {{--<option>微信</option>--}}
                    {{--<option>货到付款</option>--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<select name="status">--}}
                    {{--<option value="">订单状态</option>--}}
                    {{--<option value="0">未完成</option>--}}
                    {{--<option value="1">已完成</option>--}}
                    {{--<option value="-1">已取消</option>--}}
                {{--</select>--}}
            {{--</div>--}}
            {{--<input type="text" name="username"  placeholder="请输入订单号" autocomplete="off" class="layui-input">--}}
            {{--<button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>--}}
        {{--</form>--}}
    </div>
    <xblock>
        {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
        <span class="x-right" style="line-height:40px">共有数据：{{$list->total()}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            {{--<th>--}}
                {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th>订单编号</th>
            <th>装修类型</th>
            <th>装修面积</th>
            <th>申请时间</th>
            <th>支付状态</th>
            <th>订单状态</th>
            {{--<th>支付方式</th>--}}
            {{--<th>下单时间</th>--}}
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
            <td>{{$v->us_type}}</td>
            <td>{{$v->interior_area}}平方米</td>
            <td>{{$v->create_time}}</td>
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
            <td class="td-manage">
                {{--<a title="查看"  onclick="x_admin_show('编辑','order-view.html')" href="javascript:;">--}}
                    {{--<i class="layui-icon">&#xe63c;</i>--}}
                {{--</a>--}}
                <a title="取消订单" onclick="order_del(this,'{{$v->Id}}')" href="javascript:;">
                    <i class="layui-icon">&#xe640;</i>
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
<script type="text/javascript" src="/static/lib/layui/layui.js"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
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
    function order_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
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


    function delAll (argument) {
        var data = tableCheck.getData();
        var ids = '';
        $.each(data, function (k, v) {
            if (v != ''){
                ids += v + ',';
            }
        });
        layer.confirm('确认要删除吗？'+data,function(index){
            $.ajax({
                url:'{{url('admin/orderDelete')}}/'+ ids,
                type:'get',
                dataType:'json',
                success:function (data) {
                    console.log(data);
                    if (data.code  < 0){
                        layer.msg(data.msg,{icon:1,time:1000});
                    }else{
                        layer.msg(data.msg,{icon:1,time:1000});
                        $('.layui-form-checked').not('.header').parents("tr").find(".td-status").html('已取消');
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