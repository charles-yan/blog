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
                <form class="layui-form">
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>权限名称
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="title" name="title" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>权限规则
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="urls" name="urls" required="" lay-verify="required"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                        </label>
                        <button  class="layui-btn" lay-filter="add" lay-submit="">
                            添加
                        </button>
                    </div>
              </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;
                var is_active=0;
                //自定义验证规则

                //监听提交
                form.on('submit(add)', function(data) {
                    let obj=data.field;
                    obj.status=1;
                    $.ajax({
                        type:"POST",
                        dataType:'JSON',
                        url:'/admin/permission',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:obj,
                        success:function(res){
                            if(res.status=='success'){
                                layer.alert(res.message,{icon:6},function () {
                                    //关闭当前frame
                                    xadmin.close();
                                    // 可以对父窗口进行刷新
                                    xadmin.father_reload();
                                });
                                return
                            };
                            layer.alert(res.message,{icon:5});
                        },
                        error:function () {

                        }
                    })
                    return false;
                });

            });</script>
    </body>

</html>
