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
                        <input type="text" id="name" name="name" required="" lay-verify="required"
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
                            <tr>
                                <td>
                                    <input type="checkbox" name="like1[write]" lay-skin="primary" lay-filter="father" title="用户管理">
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" lay-skin="primary" type="checkbox" title="用户停用" value="2">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户删除">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户修改">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户改密">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户列表">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户改密">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户列表">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户改密">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户列表">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                    <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章管理" lay-filter="father">
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章添加">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章删除">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章修改">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章改密">
                                        <input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章列表">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

          //自定义验证规则
          // form.verify({
          //   name: function(value){
          //     if(value.length <= 0){
          //       return '角色名称不能为空';
          //     }
          //   }
          // });
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
                    };
                    layer.alert(res.message,{icon:5});
                }
            });
            //发异步，把数据提交给php
            // layer.alert("增加成功", {icon: 6},function () {
            //     // 获得frame索引
            //     var index = parent.layer.getFrameIndex(window.name);
            //     //关闭当前frame
            //     parent.layer.close(index);
            // });
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
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>
