<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table='article';
    public $primaryKey='id';

    protected $guarded = [];

//    public $timestamps=false;

}
