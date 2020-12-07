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
                          <span class="x-red">*</span>栏目名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="cate_name" name="cate_name" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                    <div class="layui-form-item flex-start">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>父级分类
                        </label>
                            <select name="cate_pid" lay-verify="" style="width:180px;">
                                @foreach($parent as $v)
                                    <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>排序
                        </label>
                        <div class="layui-input-inline">
                            <input type="number" id="cate_order" name="cate_order" required="" lay-verify="required"
                                   autocomplete="off" min="0" max="100" class="layui-input" value="0">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否启用</label>
                        <div class="layui-input-block">
                            <input type="checkbox"  lay-filter="encrypt"  lay-skin="switch" lay-text="开启|关闭">
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
                var status=0;
                //自定义验证规则
                form.verify({

                });
                form.on('switch(encrypt)', function(data){
                    console.log(data.elem.checked); //开关是否开启，true或者false
                    status=data.elem.checked?1:0;
                });

                //监听提交
                form.on('submit(add)', function(data) {
                    let obj=data.field;
                    obj.status=status;
                    $.ajax({
                        type:"POST",
                        dataType:'JSON',
                        url:'/admin/cate/addchild',
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
