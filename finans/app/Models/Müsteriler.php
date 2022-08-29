<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Müsteriler extends Model
{
    use HasFactory;
    protected $guarded=[];
    static function getPublicName($id)
    {
        $data=Müsteriler::where('id',$id)->get();
        if ($data[0]['musteriTipi']==0)
        {
            return $data[0]['name']." ".$data[0]['lastname'];
        }
        else
        {
            return $data[0]['firmaAdı'];
        }

    }
    static function getPhoto($id)
    {
        $data=Müsteriler::where('id',$id)->get();
        if ($data[0]['photo']!=="")
        {
            return $data[0]['photo'];
        }
        else
        {
            return "assets/demo/users/user1.jpg";
        }
    }
}
