@include('admin.common.header')
<body>
<div class="x-body">
    <form class="layui-form" action="{{url('admin/decorationEdit')}}">



            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>部门名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->name}}" id="contract" name="contract" required="" autocomplete="off" class="layui-input" lay-verify="required">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>部门职位
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->position_name}}" id="name" name="name" required="" autocomplete="off"  class="layui-input" lay-verify="required">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>备注
                </label>
                <div class="layui-input-inline" style="width: 400px;">
                    <input type="text" value="{{$list->remark}}" id="address" name="address" required="" autocomplete="off"  class="layui-input" lay-verify="required">
                </div>
            </div>

            {{--<div class="layui-form-item">--}}
                {{--<label class="layui-form-label"><span class="x-red">*</span>状态</label>--}}
                {{--<div class="layui-input-block">--}}
                    {{--<input type="radio" name="status" value="1" id="status"  @if($list->status==1) checked @endif>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<input style="display: none" type="text" id="id" name="id" required="" lay-verify="required" autocomplete="off" value="{{$v->Id}}" class="layui-input">--}}

        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                提交修改
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $(function (){
        layui.use('form', function (){
            var form = layui.form;
            //监听提交
            form.on('submit(add)', function (data){
                //     if(pic_num > 5){
                //         layer.msg('轮播图数量最多为5张');
                //         return false;
                //     }
                $(data.elem).addClass('layui-btn-disabled');
                var layer_id = layer.msg('正在努力加载中//~~');
                $.ajax({
                    url: data.form.action,
                    data: data.field,
                    type:'post',
                    dataType:'Json',
                    success: function (res){
                        $(data.elem).removeClass('layui-btn-disabled');
                        layer.close(layer_id);
                        // console.log(res);
                        // return false;
                        if (res.code > -1){
                            // console.log('1111');
                            layer.msg(res.msg, function (){
                                // var index = layer.getFrameIndex(window.name);
                                //关闭当前frame
                                // parent.layer.close(index);
                                {{--window.location.href='{{url('admin/detailInformation')}}/{{$v->Id}}';--}}
                                window.history.go(-1);
                            });
                        } else {
                            // console.log('33333');
                            layer.msg(res.msg);
                        }
                    }
                });
                return false;
            });
        });
    });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>