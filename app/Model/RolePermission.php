<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    public $table='role_permission';
    //关联表的主键
    public $primaryKey='id';

    protected $guarded = [];

    public function permission(){
        return $this->hasMany(Permission::class,'id','permission_id');
    }
}
