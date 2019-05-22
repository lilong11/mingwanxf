@include('admin.common.header')

<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">管理登录</div>
    <div id="darkbannerwrap"></div>

    <form method="post" class="layui-form" id="login_info" >
        <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
        <hr class="hr15">
        <input id="input_psw" name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" id="login_btn" onclick="login()" style="width:100%;" type="button">        <hr class="hr20" >
    </form>
</div>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    // $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    function login() {
        var url =  "{{url('admin/doLogin')}}";
        var data = $('#login_info').serialize();
        // console.log(data);return false;
        $.ajax({
            url:url,
            type:'post',
            data: data,
            dataType:'json',
            success:function (data) {
                layer.msg(data.msg);
                if(data.code == 0){
                    window.location="{{url('admin/index')}}";
                }
            },
            error:function () {
                layer.msg('登录失败，稍后再试');
            }
        })
    }
    $('#input_psw').keydown(function (event) {
        if (event.which == 13) login();
    })


</script>


<!-- 底部结束 -->
<script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
</body>
</html>