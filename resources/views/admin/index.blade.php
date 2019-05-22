@include('admin.common.header')
<body>
<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="./index.html">X-admin v2.0</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav left fast-add" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>
                <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>
                <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">{{session('admin')['real_name']}}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('个人信息','{{'adminEditPage'}}/{{session('admin')['Id']}}')">个人信息</a></dd>
                <dd><a onclick="x_admin_show('更换密码','{{url('admin/passWordEdit')}}')">更换密码</a></dd>
                <dd><a href="{{url('admin/loginOut')}}">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index"><a href="{{url('admin/index')}}">前台首页</a></li>
    </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>会员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/memberList')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/wxUserList')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>微信用户列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>订单管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/orderList')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>订单列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>工程管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/ConstructIndex')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>工程信息列表</cite>
                        </a>
                    </li > <li>
                        <a _href="{{url('admin/')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>流程验收列表</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>分类管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/site')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>装修类型</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe726;</i>
                    <cite>权限管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/adminList')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>职员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="{{url('admin/depList')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-cate.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限分类</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="admin-rule.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite>
                        </a>
                    </li >
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe726;</i>
                    <cite>部门管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{url('admin/staffList')}}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>职员列表</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/sectionList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>部门管理</cite>
                        </a>
                    </li >
                </ul>
            </li>



            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe726;</i>
                    <cite>工程流程</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="/projectList">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>工程信息</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="/projectInfo">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>工程流程</cite>
                        </a>
                    </li >
                </ul>
            </li>

            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe6ce;</i>--}}
                    {{--<cite>系统统计</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a _href="echarts1.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>拆线图</cite>--}}
                        {{--</a>--}}
                    {{--</li >--}}
                    {{--<li>--}}
                        {{--<a _href="echarts2.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>柱状图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts3.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>地图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts4.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>饼图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts5.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>雷达图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts6.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>k线图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts7.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>热力图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a _href="echarts8.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>仪表图</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="javascript:;">--}}
                    {{--<i class="iconfont">&#xe6b4;</i>--}}
                    {{--<cite>图标字体</cite>--}}
                    {{--<i class="iconfont nav_right">&#xe697;</i>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li>--}}
                        {{--<a _href="unicode.html">--}}
                            {{--<i class="iconfont">&#xe6a7;</i>--}}
                            {{--<cite>图标对应字体</cite>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='./welcome.html' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved</div>
</div>
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