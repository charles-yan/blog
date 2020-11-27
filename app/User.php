<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    //用户模型关联表 对应数据库表
    public $table = 'db_user';
    //关联表的主键
    public $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * 允许操作的字段
     * @var array
     */
    protected $fillable = [
        'username','password'
    ];
    //禁用时间戳 因为Eloquent会默认加入时间戳，可表中无这两个字段
    public $timestamps=false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
