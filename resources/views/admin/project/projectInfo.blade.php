@include('admin.common.header')

<body>
<div class="x-nav">
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="iconfont" style="line-height:30px">&#xe6aa;</i></a>
</div>
<div class="x-body">
    <div class="layui-row">
        <form class="layui-form" action="{{'/projectInfo'}}/{{$list->id}}">

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>订单id
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->order_id}}" id="order_id" name="order_id" required="" lay-verify="required"
                           autocomplete="off" class="layui-input" disabled="true">
                </div>

                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>来源
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->source}}" id="source" name="source" required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>工程编号
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->contract_no}}" id="contract_no" name="contract_no" required="" lay-verify="required"
                           autocomplete="off" class="layui-input" disabled="true">
                </div>

                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>工程名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->contract_name}}" id="contract_name" name="contract_name" required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>工程地址
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->australia}}" id="australia" name="australia" required="" lay-verify="required"
                           autocomplete="off" class="layui-input" disabled="true">
                </div>

                <label for="L_username" class="layui-form-label" disabled="true">
                    <span class="x-red">*</span>面积
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->acreage}}" id="acreage" name="acreage" required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>客户姓名
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->client_name}}" id="client_name" name="client_name" required="" lay-verify="required"
                           autocomplete="off" class="layui-input" disabled="true">
                </div>

                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>客户手机号
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->client_phone}}" id="client_phone" name="client_phone" required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>
            </div>



            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>验收结果
                </label>
                <div class="layui-input-block">
                    <input type="radio" name="troa" value="1" id="troa" title="施工中" @if($list->troa==1) checked @endif disabled="true">
                    <input type="radio" name="troa" value="2" id="troa" title="通过" @if($list->troa==2) checked @endif disabled="true">
                    <input type="radio" name="troa" value="3" id="troa" title="不通过" @if($list->troa==3) checked @endif disabled="true">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>工程状态
                </label>
                <div class="layui-input-block">
                    <input type="radio" name="contract_status" value="1" id="contract_status" title="待开工" @if($list->contract_status==1) checked @endif disabled="true">
                    <input type="radio" name="contract_status" value="2" id="contract_status" title="在建工地" @if($list->contract_status==2) checked @endif disabled="true">
                    <input type="radio" name="contract_status" value="3" id="contract_status" title="竣工" @if($list->contract_status==3) checked @endif disabled="true">
                </div>
            </div>


            <div class="layui-form-item">
            <label for="stylist_id" class="layui-form-label">
            <span class="x-red">*</span>设计师
            </label>

                <div class="layui-input-inline">
                    <input type="text" value="{{$list->stylist_name}}"  required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>


            <label for="pm_id" class="layui-form-label">
            <span class="x-red">*</span>项目经理
            </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->pm_name}}"  required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>
            </div>

            <div class="layui-form-item">
            <label for="supervisor_id" class="layui-form-label">
            <span class="x-red">*</span>监理
            </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$list->supervisor_name}}"  required=""
                           autocomplete="off" class="layui-input" disabled="true">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>开工日期
                </label>
                <div class="layui-inline layui-show-xs-block">
                    <input class="layui-input" value="{{$list->start_time}}" placeholder="开工日期" name="start_time" id="start_time" disabled="true">
                </div>
            </div>


            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>竣工日期
                </label>
                <div class="layui-inline layui-show-xs-block">
                    <input class="layui-input" value="{{$list->end_time}}" autocomplete="off" placeholder="竣工日期" name="end_time" id="end_time" disabled="true">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

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