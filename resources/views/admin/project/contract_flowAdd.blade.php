@include('admin.common.header')

<link rel="stylesheet" href="/admin/img/css/img.css">
<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>


<div class="x-body">
    <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" method="post" enctype="multipart/form-data"
              action="/contract_flowAdd">


            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>工程id
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="contract_id" name="contract_id" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>

                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>工程流程
                </label>
                <select name="type">
                    <option value="0">请选择</option>
                    <option value="1">开工形象</option>
                    <option value="2">水电阶段</option>
                    <option value="3">泥工阶段</option>
                    <option value="4">木工阶段</option>
                    <option value="5">油漆阶段</option>
                    <option value="6">安装阶段</option>
                    <option value="7">交付验收</option></select>
            </div>

            {{--<div class="layui-form-item">--}}

            {{--</div>--}}

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>备注
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="remark" name="remark" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>

                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>工程巡查
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="engineering_inspect" name="engineering_inspect" required=""
                           autocomplete="off" class="layui-input">
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>巡查备注
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="inspect_remark" name="inspect_remark" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>

                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>验收详情
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="acceptance_info" name="acceptance_info" required=""
                           autocomplete="off" class="layui-input">
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>验收情况
                </label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" id="status" title="施工中">
                    <input type="radio" name="status" value="2" id="status" title="通过">
                    <input type="radio" name="status" value="3" id="status" title="不通过">
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>巡查时间
                </label>
                <div class="layui-inline layui-show-xs-block">
                    <input class="layui-input" placeholder="开工日期" name="patrol_time" id="patrol_time">
                </div>
            </div>


            <div class="layui-form-item">
                <div class="upimg">
                    <img src="__PUBLIC__/uploads/{$vo.savepath}{$vo.savename}">
                    <input type="file" id="upgteimg" name="upgteimg[]" value="" multiple/>
                </div>
                <div class="main">
                    <div id="showimg">
                        <ul id="showui">
                        </ul>

                        <div id="showinput">

                        </div>
                    </div>
                </div>
                {{--<input multiple type="file" name="upgteimg[]" id="image" value="">--}}
                <input type="submit" value="提交">
            </div>


        </form>
    </div>
</div>

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
{{--<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>--}}
<script type="text/javascript" src="/admin/img/js/updateimg.js"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $(function () {
        layui.use('form', function () {
            var form = layui.form;
            /*
           监听select动态插入职位
           * */
            form.on('select(did)', function (data) {
                // console.log(data);
                $('[name="position"]').empty();
                $.post({
                    data: {did: data.value},
                    url: '/PositionList',
                    dataType: 'json',
                    success: function (res) {
                        // console.log(res);
                        if (res.code == 0) {

                            $('[name="position"]').append("<option value=\"0\">请选择职位 </option>");
                            for (var i = 0; i < res.info.length; i++) {
                                // console.log("<option value=\""+ res.info[i].Id +"\">"+  res.info[i].position_name +"</option>");
                                $('[name="position"]').append("<option value=\"" + res.info[i].id + "\">" + res.info[i].position_name + "</option>");
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
            form.on('submit(add)', function (data) {
                // console.log('qqq');
                $(data.elem).addClass('layui-btn-disabled');
                var layer_id = layer.msg('正在努力加载中//~~');
                $.post({
                    url: data.form.action,
                    data: data.field,
                    success: function (res) {
                        $(data.elem).removeClass('layui-btn-disabled');
                        layer.close(layer_id);
                        // console.log(res);
                        // return false;
                        if (res.code == 0) {
                            layer.msg('添加成功', function () {
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
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

<script>
    layui.use('laydate', function () {
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#patrol_time' //指定元素
            , format: 'yyyy-MM-dd HH:mm:ss'
            , type: 'datetime'
            , trigger: 'click'
        });
    });
</script>
</body>