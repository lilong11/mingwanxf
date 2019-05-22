@include('admin.common.header')
<style>
    th{
        width: 200px;
    }

</style>
<body>
@foreach($info as $v)
<div class="x-body">
    <div class="x-nav">
        <a class="layui-btn layui-btn-small layui-btn-danger" style="line-height:1.6em;margin-top:0;float:left" href="{{url('admin/ConstructIndex')}}" title="返回列表页">
            <i class="iconfont" style="line-height:30px">返回</i></a>
    </div>

    <fieldset class="layui-elem-field">
        <legend>工程信息</legend>
        <div class="layui-field-box">

            <table class="layui-table">
                <tbody>
                <tr>
                    <th>工程名称</th>
                    <td>{{$v->project_name}}</td>
                </tr>
                <tr>
                    <th>合同编号</th>
                    <td>{{$v->contract_number}}</td>
                </tr>
                <tr>
                    <th>工程地址</th>
                    <td>{{$v->project_address}}</td>
                </tr>
                <tr>
                    <th>客户姓名</th>
                    <td>{{$v->user_name}}</td>
                </tr>
                <tr>
                    <th>客户电话</th>
                    <td>{{$v->mobile_number}}</td>
                </tr>
                <tr>
                    <th>装修面积</th>
                    <td>{{$v->interior_area}}</td>
                </tr>
                <tr>
                    <th>客户注册途径</th>
                    <td>{{$v->approach}}</td>
                </tr>
                <tr>
                    <th>开工时间</th>
                    <td>
                        @if($v->start_time)
                        {{$v->start_time}}
                            @else
                        无
                            @endif
                    </td>
                </tr>
                <tr>
                    <th>竣工日期</th>
                    <td>
                        @if($v->end_time)
                        {{$v->end_time}}
                            @else
                        无
                            @endif
                    </td>
                </tr>
                <tr>
                    <th>施工状态</th>
                    <td>
                        @if($v->decoration_status == -1)
                            未开工
                            @elseif($v->decoration_status == 2)
                            已竣工
                            @else
                            在建工程
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>验收结果</th>
                    <td>
                        @if($v->acceptance_status == -1)
                            未提交
                            @elseif($v->acceptance_status == -2)
                            未通过
                            @else
                            通过
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>设计师</th>
                    <td>{{$v->designer}}</td>
                </tr>
                <tr>
                    <th>监理</th>
                    <td>{{$v->supervision}}</td>
                </tr>
                <tr>
                    <th>项目经理</th>
                    <td>{{$v->manager}}</td>
                </tr>
                <tr>
                    <th>验收单</th>
                    <td>
                        @if($v->acceptance_sheet)
                        {{$v->acceptance_sheet}}
                            @else
                            无
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </fieldset>
</div>

<div class="x-nav">

    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="{{url('admin/detailEditPage')}}/{{$v->Id}}" title="编辑">
        <i class="iconfont" style="line-height:30px">编辑</i></a>
</div>
@endforeach
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