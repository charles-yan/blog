<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <body>
        <form action="{{ url('user/store') }}" method="post">
            @csrf
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
                    <tb>
                        <input type="submit" value="提交">
                    </tb>
                </tr>
            </table>
        </form>
    </body>
</html>

