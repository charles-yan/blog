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
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
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
                                    <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','/admin/user/create',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>
                                    <input type="checkbox" name=""  lay-skin="primary">
                                  </th>
                                  <th>ID</th>
                                  <th>登录名</th>
                                  <th>邮箱</th>
                                  <th>角色</th>
                                  <th>加入时间</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                              @foreach($user as $item)
                                <tr>
                                  <td id="{{$item->id}}">
                                    <input type="checkbox" name="" lay-skin="primary">
                                  </td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>{{$item->email}}</td>
                                  <td>超级管理员</td>
                                  <td>{{$item->created_at}}</td>
                                  <td class="td-status">
                                      @if($item->is_active==1)
                                         <span class="layui-btn layui-btn-normal layui-btn-sm">已启用</span>
                                      @else
                                          <span class="layui-btn layui-btn-disabled layui-btn-sm">已停用</span>
                                      @endif
                                  </td>
                                  <td class="td-manage">
                                    <a onclick="member_stop(this,{{$item->id}})" href="javascript:;"  title="{{$item->is_active==1?'启用':'停用'}}">
                                        @if($item->is_active==1)
                                        <i class="layui-icon">&#xe601;</i>
                                        @else
                                        <i class="layui-icon">&#xe62f;</i>
                                        @endif
                                    </a>
                                    <a title="编辑"  onclick="xadmin.open('编辑','/admin/user/{{$item->id}}/edit')" href="javascript:;">
                                      <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="member_del(this,{{$item->id}})" href="javascript:;">
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
                                  <a class="prev" href="">&lt;&lt;</a>
                                  <a class="num" href="">1</a>
                                  <span class="current">2</span>
                                  <a class="num" href="">3</a>
                                  <a class="num" href="">489</a>
                                  <a class="next" href="">&gt;&gt;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
      layui.use(['laydate','form','table'], function(){
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
          var _str=$(obj).attr('title')=='启用'?'确认要停用吗?':'确认要启用吗?'
          layer.confirm(_str,function(index){
              var is_active=$(obj).attr('title')=='启用'?0:1;
              $.ajax({
                  type:'PUT',
                  dataType:'JSON',
                  url:'/admin/user/'+id,
                  data:{
                      is_active
                  },
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success:function (res) {
                    if(res.status=='success'){
                        if($(obj).attr('title')=='启用'){
                            $(obj).attr('title','停用')
                            $(obj).find('i').html('&#xe62f;');

                            $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                            layer.msg('已停用!',{icon: 5,time:1000});

                        }else{
                            $(obj).attr('title','启用')
                            $(obj).find('i').html('&#xe601;');

                            $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用').addClass('layui-btn-normal');
                            layer.msg('已启用!',{icon: 6,time:1000});
                        }
                    }else{
                        layer.msg(res.message,{icon: 5,time:1000});
                    }
                  },
              });
          });
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.ajax({
                  type: 'DELETE',
                  dataType: 'JSON',
                  url: '/admin/user/' + id,
                  data: {},
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success:function (res) {
                    if(res.status=='success'){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    };
                  }
              });
          });
      }

      function delAll () {
          let ids=[];
          $(".layui-form-checked").not('.header').parent('td').each(function (i,v) {
             var u = $(v).attr('id');
             ids.push(u);
          });
          if(!ids.length){
              layer.msg('请选中要删除项!', {icon: 6});
              return
          };
        layer.confirm('确认要删除吗?',function(index){
            $.ajax({
                type:"DELETE",
                url:'/admin/user/' + ids,
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (res) {
                    if(res.status=='success'){
                        layer.msg('删除成功', {icon: 1});
                        $(".layui-form-checked").not('.header').parents('tr').remove();
                    };
                }
            })
        });
      }
    </script>

</html>
