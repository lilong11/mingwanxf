@include('admin.common.header')

<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form" action="{{'/contractEdit'}}/{{$list->id}}">


            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>巡查结果
                </label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" id="status" title="施工中" @if($list->status==1) checked @endif>
                    <input type="radio" name="status" value="2" id="status" title="通过" @if($list->status==2) checked @endif>
                    <input type="radio" name="status" value="3" id="status" title="不通过" @if($list->status==3) checked @endif>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                    修改
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $(function (){
        layui.use('form', function () {
            var form = layui.form;
            /*
           监听select动态插入职位
           * */
            form.on('select(did)',function (data) {
                // console.log(data);
                $('[name="position"]').empty();
                $.post({
                    data:{did:data.value},
                    url:'/PositionList',
                    dataType:'json',
                    success:function (res) {
                        // console.log(res);
                        if (res.code == 0){

                            $('[name="position"]').append("<option value=\"0\">请选择职位 </option>");
                            for(var i = 0; i < res.info.length; i++){
                                // console.log("<option value=\""+ res.info[i].Id +"\">"+  res.info[i].position_name +"</option>");
                                $('[name="position"]').append("<option value=\""+ res.info[i].id +"\">"+  res.info[i].position_name +"</option>");
                            }
                            //重新渲染select选择框
                            form.render('select');
                        } else {
                            layer.msg(res.msg());
                        }
                    }
                })
            });

            //监听提交
            form.on('submit(add)', function (data){
                // console.log('qqq');
                $(data.elem).addClass('layui-btn-disabled');
                var layer_id = layer.msg('正在努力加载中//~~');
                $.post({
                    url:data.form.action,
                    data: data.field,
                    success: function (res){
                        $(data.elem).removeClass('layui-btn-disabled');
                        layer.close(layer_id);
                        // console.log(res);
                        // return false;
                        if (res.code == 0){
                            layer.msg('添加成功', function (){
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
<script>
    var _hmt = _hmt || []; (function(){
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
            elem: '#end_time' //指定元素
            ,format:'yyyy-MM-dd HH:mm:ss'
            ,type:'datetime'
            ,trigger: 'click'
        });

        laydate.render({
            elem: '#start_time' //指定元素
            ,format:'yyyy-MM-dd HH:mm:ss'
            ,type:'datetime'
            ,trigger: 'click'
        });
    });
</script>

</body>