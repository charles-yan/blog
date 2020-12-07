<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //1.获取当前请求的路由
        //App\Http\Controllers\Admin\RoleController@edit
         $route = \Route::current()->getActionName();
//         dd($route);
        //2.获取当前用户的权限组
        if(!session()->get('user')){
           return redirect('admin/login');
        };
        $user_id=session()->get('user')[0]->toArray();
        $user=User::find($user_id['id']);
        //2.1获取当前用户的角色
        $roles=$user->role;
        //存放权限对应的URLS字段列值，也就是权限列表
        $arr=[];
        foreach ($roles as $v){
            $perms=$v->permission;
            foreach ($perms as $perm){
                $arr[]=$perm->urls;
            }
        };

        //去除重复的权限表
        $arr=array_unique($arr);
        if(in_array($route,$arr)){
            return $next($request);
        }else{
           return redirect('admin/noPermission');
        }
    }
}
