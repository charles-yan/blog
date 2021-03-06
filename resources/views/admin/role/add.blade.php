<!DOCTYPE html>
<html class="x-admin-sm">

  <head>
      @include('admin.pubilc.style')
      @include('admin.pubilc.script')
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
  </head>

  <body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required=""  lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否启用</label>
                    <div class="layui-input-block">
                        <input type="checkbox"  lay-filter="encrypt"  lay-skin="switch" lay-text="开启|关闭">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                        @foreach($perms as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="{{$item->title}}" value="{{$item->id}}" lay-skin="primary" lay-filter="father" title="{{$item->title}}">
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" disabled lay-skin="primary" type="checkbox" value="2" title="显示">
                                        <input name="id[]" disabled lay-skin="primary" type="checkbox" value="2" title="添加">
                                        <input name="id[]" disabled lay-skin="primary" type="checkbox" value="2" title="修改">
                                        <input name="id[]" disabled lay-skin="primary" type="checkbox" value="2" title="删除">
                                    </div>
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                    <div class="layui-card-body">
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
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">保存</button>
              </div>
            </form>
        </div>
    </div>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
            let status=0;
            form.on('switch(encrypt)', function(data){
                console.log(data.elem.checked); //开关是否开启，true或者false
                status=data.elem.checked?1:0;
            });

          //监听提交
          form.on('submit(add)', function(data){
              let obj=data.field;
              obj.status=status;
            $.ajax({
                type:"POST",
                dataType:'JSON',
                url:'/admin/role',
                data:obj,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (res) {
                    if(res.status=='success'){
                        layer.alert(res.message,{icon:6},function () {
                            //关闭当前frame
                            xadmin.close();
                            // 可以对父窗口进行刷新
                            xadmin.father_reload();
                        });
                        return;
                    };
                    layer.alert(res.message,{icon:5});
                }
            });

            return false;
          });
        form.on('checkbox(father)', function(data){
            if(data.elem.checked){
                $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                form.render();
            }else{
               $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                form.render();
            }
         });
        });
    </script>
  </body>

</html>
