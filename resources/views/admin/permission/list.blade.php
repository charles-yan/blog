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
            <a href="">用户管理</a>
            <a>
              <cite>权限管理</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5">

                                <div class="layui-inline layui-show-xs-block">
                                    <select name="cateid">
                                      <option>规则分类</option>
                                      <option>文章</option>
                                      <option>会员</option>
                                      <option>权限</option>
                                    </select>
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <select name="contrller">
                                      <option>请控制器</option>
                                      <option>Index</option>
                                      <option>Goods</option>
                                      <option>Cate</option>
                                    </select>
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <select name="action">
                                      <option>请方法</option>
                                      <option>add</option>
                                      <option>login</option>
                                      <option>checklogin</option>
                                    </select>
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                    <input type="checkbox" name=""  lay-skin="primary">
                                  </th>
                                  <th>ID</th>
                                  <th>权限规则</th>
                                  <th>权限名称</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                              @foreach($perms as $item)
                                <tr>
                                  <td>
                                   <input type="checkbox" name=""  lay-skin="primary">
                                  </td>
                                  <td>{{$item->id}}</td>
                                  <td>{{$item->urls}}</td>
                                  <td>{{$item->title}}</td>
                                  <td class="td-manage">
                                    <a title="编辑"  onclick="xadmin.open('编辑','xxx.html')" href="javascript:;">
                                      <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">
                                      <i class="layui-icon">&#xe640;</i>
                                    </a>
                                  </td>
                                </tr>
                              @endforeach
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                    @if($perms->onFirstPage())
                                        <a class="prev-dark" href="javascript:;">&lt;&lt;</a>
                                    @else
                                        <a class="prev-active" href="{{$perms->previousPageUrl()}}">&lt;&lt;</a>
                                    @endif
                                     <span  class="current">{{$perms->currentPage()}}</span>
                                        @if($perms->hasMorePages())
                                            <a class="move-active" href="{{$perms->nextPageUrl()}}">&gt;&gt;</a>
                                        @else
                                            <a class="move-dark" href="javascript:;">&gt;&gt;</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }

          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();

        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
</html>
