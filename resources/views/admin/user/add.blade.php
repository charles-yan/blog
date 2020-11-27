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
                          <span class="x-red">*</span>登录名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="username" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为您唯一的登入名
                      </div>
                  </div>
{{--                  <div class="layui-form-item">--}}
{{--                      <label for="phone" class="layui-form-label">--}}
{{--                          <span class="x-red">*</span>手机--}}
{{--                      </label>--}}
{{--                      <div class="layui-input-inline">--}}
{{--                          <input type="text" id="phone" name="phone" required="" lay-verify="phone"--}}
{{--                          autocomplete="off" class="layui-input">--}}
{{--                      </div>--}}
{{--                      <div class="layui-form-mid layui-word-aux">--}}
{{--                          <span class="x-red">*</span>将会成为您唯一的登入名--}}
{{--                      </div>--}}
{{--                  </div>--}}
                  <div class="layui-form-item">
                      <label for="L_email" class="layui-form-label">
                          <span class="x-red">*</span>邮箱
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="L_email" name="email" required="" lay-verify="email"
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否激活</label>
                        <div class="layui-input-block">
                            <input type="checkbox"  lay-filter="encrypt"  lay-skin="switch" lay-text="开启|关闭">
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
                          <span class="x-red">*</span>密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_pass" name="pass" required="" lay-verify="pass"
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          6到16位字符
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                          <span class="x-red">*</span>确认密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="L_repass" name="repass" required="" lay-verify="repass"
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
                form.verify({
                    nikename: function(value) {
                        if (value.length < 5) {
                            return '昵称至少得5个字符啊';
                        }
                    },
                    pass: [/(.+){6,16}$/, '密码必须6到16位'],
                    repass: function(value) {
                        if ($('#L_pass').val() != $('#L_repass').val()) {
                            return '两次密码不一致';
                        }
                    }
                });
                form.on('switch(encrypt)', function(data){
                    console.log(data.elem.checked); //开关是否开启，true或者false
                    is_active=data.elem.checked?1:0;
                });

                //监听提交
                form.on('submit(add)', function(data) {
                    let obj=data.field;
                    obj.is_active=is_active;
                    $.ajax({
                        type:"POST",
                        dataType:'JSON',
                        url:'/admin/user',
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
