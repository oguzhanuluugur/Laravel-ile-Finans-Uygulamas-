<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalem extends Model
{
    //use HasFactory;
    protected $guarded=[];

    static function getList($type)
    {
        $list=Kalem::where('kalemTipi',$type)->get();
        return $list;
    }
}
