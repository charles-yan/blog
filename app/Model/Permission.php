<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //链接数据表
    public $table='permission';
    //关联表的主键
    public $primaryKey='id';
    /**
     * The attributes that are mass assignable.
     * 可批量赋值属性
     * @var array
     */
    protected $fillable = [
        'title','urls','status'
    ];

    /**
     * 不可批量赋值的属性 表示所有的参数都可操作
     * @var array
     */
//    protected $guarded = [];

    //禁用时间戳 因为Eloquent会默认加入时间戳，可表中无这两个字段
//    public $timestamps=false;

//    public function permission(){
//        return $this->hasMany(RolePermission::class,'id','permission_id');
//    }

}
