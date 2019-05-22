@include('admin.common.header')
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-form-pane">
            <input class="layui-input" placeholder="部门名称" name="name">
            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>查询</button>
        </form>
    </div>
    {{--<blockquote class="layui-elem-quote">每个tr 上有两个属性 cate-id='1' 当前分类id fid='0' 父级id ,顶级分类为 0，有子分类的前面加收缩图标<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote>--}}
    <xblock>
        {{--<button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>--}}
        <button class="layui-btn" onclick="x_admin_show('添加部门','{{url('admin/depAddPage')}}',400,250)"><i class="layui-icon"></i>添加部门</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$Dlist->total()}} 条</span>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            {{--<th width="20">--}}
                {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</th>--}}
            <th width="30">ID</th>
            <th width="80">部门名称</th>
            <th width="150">部门职位</th>
            <th width="100">备注</th>
            <th width="30">状态</th>
            <th width="250">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Dlist as $v)
        <tr>
            {{--<td>--}}
                {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->Id}}'><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</td>--}}
            <td>{{$v->Id}}</td>
            <td>{{$v->department_name}}</td>

            <td>
                <div style="width: 100%;">
                    @foreach($Plist as $k => $vv)
                        @if( $vv->did == $v->Id )
                            {{$vv->position_name}}
                        @endif
                    @endforeach
                    {{--<button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','admin-edit.html')" ><i class="layui-icon">&#xe642;</i>编辑</button>--}}
                </div>
            </td>

            <td>{{$v->remark}}</td>
            <td>
                <input type="checkbox" name="switch"  lay-text="开启|停用"  checked="" lay-skin="switch">
            </td>
            <td class="td-manage">
                <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','{{url('admin/decorationEdit')}}/{{$v->Id}}')" ><i class="layui-icon">&#xe642;</i>编辑</button>
                <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('编辑','{{url('admin/positionAdd')}}/{{$v->Id}}',400,250)" ><i class="layui-icon">&#xe642;</i>添加职位</button>
                {{--<button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>--}}
            </td>
        </tr>
        {{--<tr>--}}
            {{--<td>职位：</td>--}}
            {{--<td>--}}
            {{--<div style="width: 100%;">--}}
            {{--@foreach($Plist as $k => $vv)--}}
            {{--@if( $vv->did == $v->Id )--}}
            {{--{{$vv->position_name}}--}}
            {{--@endif--}}
            {{--@endforeach--}}
            {{--<button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','admin-edit.html')" ><i class="layui-icon">&#xe642;</i>编辑</button>--}}
            {{--</div>--}}
            {{--</td>--}}
            {{--<td>--}}
                {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$vv->pid}}'><i class="layui-icon">&#xe605;</i></div>--}}
            {{--</td>--}}
            {{--<td>职位</td>--}}

            {{--<td >--}}
                {{--@foreach($Plist as $k => $vv)--}}
                    {{--@if( $vv->did == $v->Id )--}}
               {{--{{$vv->position_name}}--}}
                    {{--@endif--}}
                {{--@endforeach--}}
                {{--<button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','admin-edit.html')" ><i class="layui-icon">&#xe642;</i>编辑</button>--}}
            {{--</td>--}}

            {{--<td><input type="text" class="layui-input x-sort" name="order" value="1"></td>--}}
            {{--<td>--}}
                {{--<input type="checkbox" name="switch"  lay-text="开启|停用"  checked="" lay-skin="switch">--}}
            {{--</td>--}}
            {{--<td class="td-manage">--}}

                {{--<button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('编辑','admin-edit.html' ,400,250)" ><i class="layui-icon">&#xe642;</i>添加子栏目</button>--}}
                {{--<button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{$vv->pid}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>--}}
            {{--</td>--}}


        {{--</tr>--}}
        </tbody>
            @endforeach

    </table>
    <div class="page">
        <div>
            {{$Dlist->links()}}
        </div>
    </div>
</div>
<style type="text/css">

</style>
<script>
    // layui.use(['form'], function(){
    //     form = layui.form;
    //
    // });



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