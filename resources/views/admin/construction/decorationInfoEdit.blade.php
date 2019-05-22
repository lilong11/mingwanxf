@include('admin.common.header')
<body>
<div class="x-body">
    <form class="layui-form" action="{{url('admin/decorationEdit')}}">
        {{--@if(!empty($info))--}}
        @foreach($info as $v)


                {{--<input type="hidden" id="input_ware_pic" name="ware_pic" value="@if($v->pic_url){{$v->pic_url}}@endif">--}}
                {{--<input type="hidden" id="input_carousel_ware_pic" name="carousel_pic" value="@if($v->pic_url){{$v->pic_url}}@endif">--}}
                {{--<div class="layui-form-item">--}}
                    {{--<label for="name" class="layui-form-label">--}}
                        {{--<span class="x-red">*</span>轮播图--}}
                    {{--</label>--}}
                    {{--<table style="width: 600px; height: 120px;">--}}
                        {{--<tr>--}}
                            {{--<td class="pic_arr">--}}
                                {{--@if($v->pic_arr != null)--}}
                                    {{--@foreach($v->pic_arr as $vv)--}}
                                        {{--<div style="width:120px; height:120px; margin-left:20px; float: left"><img width="120" height="120" src='{{$vv}}' style="float: left"/> <img  src="{{asset("admin/images/chahao.jpg")}}" class="del_pic" style="width: 20px; height: 20px; margin-left: 110px; margin-top: -240px;" alt=""></div>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--</table>--}}
                    {{--<img id="carousel_pic" width="200" height="200" src="{{asset('Admin/images/default.png')}}" style="float: left" />--}}
                    {{--<div class="layui-form-mid layui-word-aux">--}}
                        {{--<span class="x-red">*</span>最多只能上传5张大小为170*140图片--}}
                    {{--</div>--}}
                    {{--<button type="button" class="layui-btn" id="ware_carousel_pic_btn" style="float: left;margin: 50px 0 0 -180px;">--}}
                        {{--<i class="layui-icon">&#xe67c;</i>上传图片--}}
                    {{--</button>--}}
                {{--</div>--}}
        {{----}}

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>合同编号
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$v->contract_number}}" id="contract" name="contract" required="" autocomplete="off" class="layui-input" lay-verify="required">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>项目名称
                </label>
                <div class="layui-input-inline">
                    <input type="text" value="{{$v->project_name}}" id="name" name="name" required="" autocomplete="off"  class="layui-input" lay-verify="required">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>项目地址
                </label>
                <div class="layui-input-inline" style="width: 400px;">
                    <input type="text" value="{{$v->project_address}}" id="address" name="address" required="" autocomplete="off"  class="layui-input" lay-verify="required">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span>装修状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="decoration_status" value="-1" id="modify_status" title="待开工" @if($v->decoration_status==-1) checked @endif>
                    <input type="radio" name="decoration_status" value="1" id="modify_status" title="在建工地" @if($v->decoration_status==1) checked @endif>
                    <input type="radio" name="decoration_status" value="2" id="modify_status" title="竣工" @if($v->decoration_status==2) checked @endif>
                </div>
            </div>

        <input style="display: none" type="text" id="id" name="id" required="" lay-verify="required" autocomplete="off" value="{{$v->Id}}" class="layui-input">

        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>设计师
            </label>
            <div class="layui-input-inline">
                <select name="designer">
                    @if($v->designer_id != null)
                        <option value="{{$v->designer_id}}">{{$v->designer}}</option>
                    @else
                        <option value="">请选择设计师</option>
                    @endif
                    @foreach($v->designer_list as $vv)
                    <option value="{{$vv['Id']}}">{{$vv['real_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>项目经理
            </label>
            <div class="layui-input-inline">
                <select name="manager">
                    @if($v->manager_id != null)
                        <option value="{{$v->manager_id}}">{{$v->manager}}</option>
                    @else
                        <option value="">请选择项目经理</option>
                    @endif
                    @foreach($v->manager_list as  $mm)
                        <option value="{{$mm['Id']}}">{{$mm['real_name']}}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>监理
            </label>
            <div class="layui-input-inline">
                <select name="supervisor">
                    @if($v->supervision_id != null)
                        <option value="{{$v->supervision_id}}">{{$v->supervision}}</option>
                    @else
                        <option value="">请选择监理</option>
                    @endif
                    @foreach($v->supervisor_list as $ss)
                        <option value="{{$ss['Id']}}">{{$ss['real_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endforeach
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
    {{--pic_num = "{{$count}}";--}}
    $(function (){
        {{--layui.use('upload', function (){--}}
            {{--var upload = layui.upload;--}}
            {{--//执行实例--}}
            {{--// console.log(upload);--}}
            {{--// return false;--}}
            {{--var  uploadCarousel = upload.render({--}}
                {{--elem: '#ware_carousel_pic_btn',//绑定元素--}}
                {{--url: '{{url('admin/picUpload')}}', //上传接口--}}
                {{--field: 'image',--}}
                {{--done: function (res){--}}
                    {{--//上传完毕回调--}}
                    {{--if (res.code == 0){--}}
                        {{--var pic_url = res.info.path;--}}
                        {{--// console.log(carousel_pic.class());--}}
                        {{--$('.pic_arr').append('<div style="width:120px; height:120px; margin-left:20px; float: left"><img width="120" height="120" src='+pic_url+' style="float: left"/> <img  src="{{asset("admin/images/chahao.jpg")}}" class="del_pic" style="width: 20px; height: 20px; margin-left: 110px; margin-top: -240px;" alt=""></div>');--}}
                        {{--var pic_arr = $('#input_carousel_ware_pic').val();--}}
                        {{--// console.log(pic_arr);--}}
                        {{--input_carousel_ware_pic.value = $.trim(pic_arr)+pic_url+",";--}}
                        {{--// var pic_arr1 = $('#input_carousel_ware_pic').val();--}}
                        {{--// console.log(pic_arr1);--}}
                        {{--pic_num ++;--}}
                        {{--// console.log(pic_num);--}}
                    {{--}--}}
                {{--}--}}
            {{--})--}}
        {{--});--}}

        {{--$(document).on('click','.del_pic',function (){--}}
            {{--var src = $(this).prev().attr('src');--}}
            {{--// console.log(src);--}}
            {{--var pic_arr = $('#input_carousel_ware_pic').val();--}}
            {{--var arr = $.trim(pic_arr).split(',');--}}
            {{--// console.log(arr);--}}
            {{--for (i = 0; i<arr.length; i++){--}}
                {{--if(src == arr[i]){--}}
                    {{--arr.splice(i,1);--}}
                {{--}--}}
            {{--}--}}
            {{--// console.log(arr);--}}
            {{--if(arr.length > 0){--}}
                {{--$('#input_carousel_ware_pic').val(arr.toString());--}}
            {{--}else{--}}
                {{--$('#input_carousel_ware_pic').val('');--}}
            {{--}--}}
            {{--var pic_arr1 = $('#input_carousel_ware_pic').val();--}}
            {{--console.log(pic_arr1);--}}
            {{--$(this).parent().remove();--}}
            {{--pic_num --;--}}
        {{--});--}}

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