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
                    <span class="x-red">*</span>文章标题
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="title" name="title" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item flex-start">
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>文章分类
                </label>
                <select name="cate_id">
                    @foreach($cate as $item)
                        <option value="{{$item->cate_id}}">{{$item->cate_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-form-item">
                <label for="username" class="layui-form-label">
                   排序
                </label>
                <div class="layui-input-inline">
                    <input type="number" id="article_order" name="article_order"
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
                <label class="layui-form-label">缩略图</label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="art_thumb">
                    <button type="button" class="layui-btn" id="upload">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img src="" id="art_thumb_img" alt="" style="width:80px;height: 80px">
                </div>
            </div>
            <div class="layui-form-item">
                <!-- 加载编辑器的容器 -->
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <script id="container"  name="content" type="text/plain">这里写你的初始化内容</script>
                    <!-- 配置文件 -->
                    <script type="text/javascript" src="{{asset('static/neditor/neditor.config.js')}}"></script>
                    <!-- 编辑器源码文件 -->
                    <script type="text/javascript" src="{{asset('static/neditor/neditor.all.js')}}"></script>
                    <!-- 实例化编辑器 -->
                    <script type="text/javascript">
                        var ue = UE.getEditor('container');
                        console.log(ue,111111);
                    </script>
                </div>
            </div>
            <div class="layui-form-item" >
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <div class="layui-tab">
                        <ul class="layui-tab-title">
                            <li class="layui-this">makedown编辑</li>
                            <li id="pre-btn">预览</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <textarea id="z-text" name="makedown"  placeholder="请输入" class="layui-textarea"></textarea>
                            </div>
                            <div class="layui-tab-item">
                                <textarea id="z-text-pre" disabled placeholder="请输入" class="layui-textarea"></textarea>
                            </div>
                        </div>
                    </div>
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
<script>


</script>
<script>
    layui.use(['form', 'layer','element','upload'], function() {
        $ = layui.jquery;

        var element = layui.element;
        var upload = layui.upload;
        var form = layui.form,
            layer = layui.layer;
        //执行实例
        var uploadInst = upload.render({
            elem: '#upload' //绑定元素
            ,url: '/admin/article/upload' //上传接口
            ,accept:'images'
            ,headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            ,done: function(res){
                //上传完毕回调
                console.log("上传成功",res);
                if(res.SeverNo=='200'){
                    $('#art_thumb_img').attr('src','/uploads/'+res['ResulData']);
                    $('input[name=art_thumb]').val(res['ResulData']);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });
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
                url:'/admin/article',
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

        $("#pre-btn").click(function () {
            $.ajax({
                url:'/admin/article/pre_mk',
                type:"post",
                data:{
                    cont:$('#z-text').val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (res) {
                    $('#z-text-pre').html(res)
                },
                error:function () {

                }
            })
        });
    });</script>
</body>
</html>
