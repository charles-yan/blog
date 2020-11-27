<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    @include('admin.pubilc.style')
    @include('admin.pubilc.script')
</head>
<body class="login-bg">
    <div class="video-bg">
        <video src="{{asset('admin/video/bg.mp4')}}" autoplay  muted="muted" loop="loop" class="my-video"></video>
    </div>
    <div class="login layui-anim layui-anim-up">
        <div class="message">后台登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" action="{{url('admin/doLogin')}}" class="layui-form" >
            @csrf
            @if (count($errors) > 0)
                <div class="alert">
                    <ul style="background: #63bbcc;color:white;padding:10px;margin: 10px 0">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        @else
                            <li>{{$errors}}</li>
                        @endif
                    </ul>
                </div>
            @endif
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="captcha" style="width:150px;height:40px;float: left" lay-verify="required" placeholder="验证码"  type="text" class="layui-input">
            <img src="{{captcha_src()}}" alt="" style="float: right" onclick="this.src='{{captcha_src()}}'+Math.random()">
{{--            @if($errors->has('captcha'))--}}
{{--                <p class="text-danger text-left"><strong>{{$errors->first('captcha')}}</strong></p>--}}
{{--            @endif--}}
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;"  type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {

            {{--layui.use('form', function(){--}}
            {{--  var form = layui.form;--}}
            {{--  return--}}
            {{--  form.on('submit(login)', function(data){--}}
            {{--      let field=data.field;--}}
            {{--      let obj={'_token':"{{ csrf_token() }}"};--}}
            {{--      field=Object.assign(field,obj);--}}
            {{--      $.ajax('/admin/doLogin',{--}}
            {{--          type:'post',--}}
            {{--          data:field,--}}
            {{--          success:function (res) {--}}

            {{--          },--}}
            {{--      })--}}
            {{--  --}}
            {{--      //表单验证--}}
            {{--      // layer.msg(JSON.stringify(data.field),function(){--}}
            {{--      //   location.href='index.html'--}}
            {{--      // });--}}
            {{--    return false;--}}
            {{--  });--}}
            {{--});--}}
        })
    </script>
    <!-- 底部结束 -->
</body>
</html>
