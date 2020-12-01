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
        <form class="layui-form layui-form-pane">
            <input type="text" name="id" hidden value="{{$role->id}}">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>角色名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" value="{{$role->name}}" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否启用</label>
                <div class="layui-input-block">
                    <input type="checkbox" checked="{{$role->status}}" value="{{$role->status}}" id="encrypt"  lay-filter="encrypt"  lay-skin="switch" lay-text="开启|关闭">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">
                    拥有权限
                </label>
                <table class="layui-table layui-input-block">
                    <tbody>
                    @foreach($perms as $item)
                        <tr>
                            <td>
                                @if(in_array($item->id,$own_arr))
                                    <input type="checkbox" checked name="premssion_id[]" value="{{$item->id}}" lay-skin="primary" lay-filter="father" title="{{$item->title}}">
                                @else
                                    <input type="checkbox" name="premssion_id[]" value="{{$item->id}}" lay-skin="primary" lay-filter="father" title="{{$item->title}}">
                                @endif
                            </td>
                            <td>
                                @if(in_array($item->id,$own_arr))
                                <div class="layui-input-block">
                                    <input name="prems_id_{{$item->id}}[]" checked disabled lay-skin="primary" type="checkbox" value="show" title="显示">
                                    <input name="prems_id_{{$item->id}}[]" checked disabled lay-skin="primary" type="checkbox" value="add" title="添加">
                                    <input name="prems_id_{{$item->id}}[]" checked disabled lay-skin="primary" type="checkbox" value="edit" title="修改">
                                    <input name="prems_id_{{$item->id}}[]" checked  disabled lay-skin="primary" type="checkbox" value="del" title="删除">
                                </div>
                                @else
                                    <div class="layui-input-block">
                                        <input name="prems_id_{{$item->id}}[]" disabled lay-skin="primary" type="checkbox" value="show" title="显示">
                                        <input name="prems_id_{{$item->id}}[]" disabled lay-skin="primary" type="checkbox" value="add" title="添加">
                                        <input name="prems_id_{{$item->id}}[]" disabled lay-skin="primary" type="checkbox" value="edit" title="修改">
                                        <input name="prems_id_{{$item->id}}[]" disabled lay-skin="primary" type="checkbox" value="del" title="删除">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
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
                <button class="layui-btn" lay-submit="" lay-filter="save">保存编辑</button>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form,layer = layui.layer;
        let status=0;
        let checked=[];
        form.on('switch(encrypt)', function(data){
            console.log(data.elem.checked); //开关是否开启，true或者false
            status=data.elem.checked?1:0;
        });

        form.on('checkbox(father)',function (data) {
            if(data.elem.checked){
                checked.push(data.value);
                $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                form.render();
            }else{
                if(!checked.length)return;
                $.each(checked,function (index,value) {
                    if(data.value==value){
                        checked.splice(index,1);
                    };
                });
                $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                form.render();
            };
        });
        //监听提交
        form.on('submit(save)', function(data){
            $("#encrypt").attr("checked", function() {
                if ($(this).is(":checked")) {
                    status=1;
                } else {
                    status=0;
                }
            });
            var id=$('input[name=id]').val();
            let obj=data.field;
            // let obj={};
            // obj.id=data.field.id;
            // obj.name=data.field.name;
            obj.status=status;
            // obj.ids=checked.join(',');
            $.ajax({
                type:'PUT',
                dataType:'JSON',
                url:'/admin/role/'+id,
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
                        return;
                    };
                    layer.alert(res.message,{icon:5});
                }
            });
            return false;
        });
    });
</script>
</body>

</html>
