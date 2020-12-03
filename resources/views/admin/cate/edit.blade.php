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
                    <input type="text" name="id" hidden value="{{$user->id}}">
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>登录名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="username" value="{{$user->username}}" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>邮箱
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="L_email" name="email" value="{{$user->email}}" required="" lay-verify="email"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>
                      </div>
                  </div>
{{--                  <div class="layui-form-item">--}}
{{--                      <label class="layui-form-label"><span class="x-red">*</span>角色</label>--}}
{{--                      <div class="layui-input-block">--}}
{{--                        <input type="checkbox" name="like1[write]" lay-skin="primary" title="超级管理员" checked="">--}}
{{--                        <input type="checkbox" name="like1[read]" lay-skin="primary" title="编辑人员">--}}
{{--                        <input type="checkbox" name="like1[write]" lay-skin="primary" title="宣传人员" checked="">--}}
{{--                      </div>--}}
{{--                  </div>--}}
                  <div class="layui-form-item">
                      <label for="L_pass" class="layui-form-label">
                          <span class="x-red"></span>重置密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_pass" name="pass" required=""
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          6到16个字符
                      </div>
                  </div>
{{--                  <div class="layui-form-item">--}}
{{--                      <label for="L_repass" class="layui-form-label">--}}
{{--                          <span class="x-red">*</span>确认密码--}}
{{--                      </label>--}}
{{--                      <div class="layui-input-inline">--}}
{{--                          <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"--}}
{{--                          autocomplete="off" class="layui-input">--}}
{{--                      </div>--}}
{{--                  </div>--}}
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="save" lay-submit="">
                          保存
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

                //自定义验证规则
                // form.verify({
                //     pass: [/(.+){6,12}$/, '密码必须6到12位'],
                // });

                //监听提交
                form.on('submit(save)', function(data) {
                    var id=$('input[name=id]').val();
                    $.ajax({
                            type:'PUT',
                            dataType:'JSON',
                            url:'/admin/user/'+id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data:data.field,
                            success:function (res) {
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

                        });
                    return false;
                });

            });</script>
    </body>

</html>
