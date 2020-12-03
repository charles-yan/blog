<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //用户模型关联表 对应数据库表
    public $table = 'admin_user';
    //关联表的主键
    public $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * 允许操作的字段
     * @var array
     */
    protected $fillable = [
        'username','password','email','is_active','avatar',
    ];
    //禁用时间戳 因为Eloquent会默认加入时间戳，可表中无这两个字段
//    public $timestamps=false;

    //添加动态属性：关联权限表
    public function role(){
        return $this->belongsToMany(Role::class,'user_role','user_id','role_id','','id');
    }

}
