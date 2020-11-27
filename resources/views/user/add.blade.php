<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <body>
        <from action="{{url('user/store')}}}" method="post">
            <table>
                <tr>
                    <td>用户名</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>密码</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <input type="submit" value="提交">
                </tr>
            </table>
        </from>
    </body>
</html>

