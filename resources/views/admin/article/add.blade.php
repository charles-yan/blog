<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    @include('admin.pubilc.style')
    @include('admin.pubilc.script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
</head>
<body>
<div class="x-nav">
                <span class="layui-breadcrumb">
                    <a href="">首页</a>
                    <a href="">文章管理</a>
                    <a>
                        <cite>添加文章</cite></a>
                </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
    </a>
</div>

<form action="" class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">输入框</label>
        <div class="layui-input-block">
            <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
</form>

</body>
</html>
