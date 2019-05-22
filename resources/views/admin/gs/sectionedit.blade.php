@include('admin.common.header')
<body>
<div class="x-body">
    <form class="layui-form" action="{{'/sectionedit'}}/{{$list->id}}">

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>部门名称
            </label>
            <div class="layui-input-inline">
                <input type="text" value="{{$list->name}}" id="name" name="name" required="" autocomplete="off" class="layui-input" lay-verify="required">
            </div>
        </div>


        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>状态
            </label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" id="status" title="开启" @if($list->status==1) checked @endif>
                <input type="radio" name="status" value="2" id="status" title="关闭" @if($list->status==2) checked @endif>
            </div>
        </div>

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
    $(function () {
        layui.use('form', function () {
            var form = layui.form;
            //监听提交
            form.on('submit(add)', function (data) {
                $(data.elem).addClass('layui-btn-disabled');
                var layer_id = layer.msg('正在努力加载中//~~');
                $.post({
                    url:data.form.action,
                    data: data.field,
                    success: function (res) {
                        $(data.elem).removeClass('layui-btn-disabled');
                        layer.close(layer_id);
                        // console.log(res);
                        // return false;
                        if (res.code == 0) {
                            layer.msg(res.msg, function (){
                                var index = parent.layer.getFrameIndex(window.name);
                                //关闭当前frame
                                parent.layer.close(index);
                                window.parent.location.reload();
                            });
                        } else {
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