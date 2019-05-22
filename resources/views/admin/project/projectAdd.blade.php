@include('admin.common.header')

<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
    <form class="layui-form layui-col-md12 x-so" method="post" action="{{'/projectAdd'}}">

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>订单id
            </label>
            <div class="layui-input-inline">
                <input type="text" id="order_id" name="order_id" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>来源
            </label>
            <div class="layui-input-inline">
                <input type="text" id="source" name="source" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>工程编号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="contract_no" name="contract_no" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>工程名称
            </label>
            <div class="layui-input-inline">
                <input type="text" id="contract_name" name="contract_name" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>工程地址
            </label>
            <div class="layui-input-inline">
                <input type="text" id="australia" name="australia" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>面积
            </label>
            <div class="layui-input-inline">
                <input type="text" id="acreage" name="acreage" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>客户姓名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="client_name" name="client_name" required="" lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>

            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>客户手机号
            </label>
            <div class="layui-input-inline">
                <input type="text" id="client_phone" name="client_phone" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>



        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>验收结果
            </label>
            <div class="layui-input-block">
                <input type="radio" name="troa" value="1" id="troa" title="施工中">
                <input type="radio" name="troa" value="2" id="troa" title="通过">
                <input type="radio" name="troa" value="3" id="troa" title="不通过">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>工程状态
            </label>
            <div class="layui-input-block">
                <input type="radio" name="contract_status" value="1" id="contract_status" title="待开工">
                <input type="radio" name="contract_status" value="2" id="contract_status" title="在建工地">
                <input type="radio" name="contract_status" value="3" id="contract_status" title="竣工">
            </div>
        </div>


        <div class="layui-form-item">
            <label for="stylist_id" class="layui-form-label">
                <span class="x-red">*</span>设计师
            </label>
            <div class="layui-input-inline">
                <select id="stylist_id" name="stylist_id" class="stylist_id" >
                    <option value="">请选择</option>
                    @foreach($list as $v)
                        <option value="{{$v->id}}">{{$v->username}}</option>
                    @endforeach
                </select>
            </div>

            <label for="pm_id" class="layui-form-label">
                <span class="x-red">*</span>项目经理
            </label>
            <div class="layui-input-inline">
                <select id="pm_id" name="pm_id" class="pm_id">
                    <option value="">请选择</option>
                    @foreach($list as $v)
                        <option value="{{$v->id}}">{{$v->username}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="supervisor_id" class="layui-form-label">
                <span class="x-red">*</span>监理
            </label>
            <div class="layui-input-inline">
                <select id="supervisor_id" name="supervisor_id" class="supervisor_id" lay-filter="did">
                    <option value="">请选择</option>
                    @foreach($list as $v)
                        <option value="{{$v->id}}">{{$v->username}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>开工日期
            </label>
        <div class="layui-inline layui-show-xs-block">
            <input class="layui-input" placeholder="开工日期" name="start_time" id="start_time">
        </div>
        </div>


        <div class="layui-form-item">
            <label for="L_username" class="layui-form-label">
                <span class="x-red">*</span>竣工日期
            </label>
        <div class="layui-inline layui-show-xs-block">
            <input class="layui-input"  autocomplete="off" placeholder="竣工日期" name="end_time" id="end_time">
        </div>
        </div>

        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">
                增加
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