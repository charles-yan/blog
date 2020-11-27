<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//添加后台登录
Route::group(['prefix'=>'admin','namespase'=>'admin',],function(){
    Route::get('login','LoginController@login');
    Route::post('doLogin','LoginController@doLogin');
});

//添加中间件 限制未登录时打开
Route::group(['prefix'=>'admin','middleware'=>'IsLogin'],function (){
    Route::get('index','LoginController@index');
    Route::get('welcome','LoginController@welcome');
    Route::get('logout','LoginController@logout');
    //后台用户相关模块
    Route::resource('user','Admin\UserController');
    //角色模块
    Route::resource('role','Admin\RoleController');
    //权限模块
    Route::resource('permission','Admin\PermissionController');
});




//添加用户路由
//Route::get('user/add','UserController@add');
//添加执行用户路由
//Route::post('user/store','UserController@store');
//用户列表
//Route::get('user/index','UserController@index');
//修改用户名和密码
//Route::get('user/edit/{id}','UserController@edit');
//更新
//Route::post('user/update','UserController@update');
//删除
//Route::get('user/del/{id}','UserController@destroy');
