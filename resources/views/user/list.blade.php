<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<script src="https://cdn.staticfile.org/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/layer/3.1.1/layer.min.js"></script>
{{--<script src="/public/js/layer/layer.js"></script>--}}
<body>
    <table border>
        <tr>
            <td>id</td>
            <td>用户名</td>
            <td>密码</td>
            <td>操作</td>
        </tr>
        @foreach($user as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->username}}</td>
            <td>{{$v->password}}</td>
            <td><a href="/user/edit/{{$v->id}}">修改</a>|<a href="javascript:" onclick="del_member(this,{{$v->id}})">删除</a></td>
        </tr>
        @endforeach
    </table>
    <script>
        function del_member(obj,id) {
            layer.confirm('你确定要删除？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.get('/user/del/'+id,function (res) {
                    if(res.status=='success'){
                        $(obj).parents('tr').remove();
                    };
                    layer.msg(res.message, {icon: res.status=='success'?6:5});
                })
            }, function(){
                layer.msg('你操作了取消', {icon: 0});
            });
        }
    </script>
</body>
</html>
