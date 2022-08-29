<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserPermissions extends Model
{
    use HasFactory;
    protected $guarded=[];
    static function getKontrol($userId,$permissionId)
    {
        $c=UserPermissions::where('userId',$userId)->where('permissionsId',$permissionId)->count();
        return ($c!=0) ? true : false;
    }
    static function getMyControl($permissionId)
    {
        $c=UserPermissions::where('userId',Auth::id())->where('permissionsId',$permissionId)->count();
        return ($c!=0) ? true : false;
    }
}
