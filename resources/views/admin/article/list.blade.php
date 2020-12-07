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
                        <cite>文章分类</cite></a>
                </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-card-header">
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
            <button class="layui-btn" onclick="xadmin.open('添加文章','/admin/article/create',600,400)"><i class="layui-icon"></i>添加</button>
        </div>
        <div class="layui-card-body">
            <table class="layui-table layui-form">
                <colgroup>
                    <col width="150">
                    <col width="200">
                    <col>
                </colgroup>
                <thead>
                    <tr>
                        <th>文章标题</th>
                        <th>作者</th>
                        <th>是否发布</th>
                        <th>排序</th>
                        <th>文章分类</th>
                        <th>创建时间</th>
                        <th>最后更新时间</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>贤心</td>
                        <td>贤心111</td>
                        <td><input type="checkbox" value="1" name="switch" lay-text="开启|停用" lay-filter="check" lay-skin="switch"></td>
                        <td><input type="text" value="1" class="layui-input x-sort" name="cate_order" ></td>
                        <td><span>深阅读</span></td>
                        <td>2016-11-29 00:00:00</td>
                        <td>2016-11-29 11:00:33</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <script>

        </script>
    </body>
</html>
