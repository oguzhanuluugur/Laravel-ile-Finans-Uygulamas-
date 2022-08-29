<?php

namespace App\Http\Controllers\front\user;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\FaturaIslem;
use App\Models\Logger;
use App\Models\User;
use App\Models\UserPermissions;
use App\Models\Ürün;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{


    public function index()
    {
        return view('front.user.index');
    }
    public function create()
    {
        return view('front.user.create');
    }
    public function store(Request $request)
    {
        $all = $request->except('_token');
        $c = User::where('email',$all['email'])->count();
        if ($c == 0) {
            $permission=(isset($all['permission'])) ? $all['permission'] : [];
            unset($all['permission']);
            $all['password'] = md5($all['password']);
            $create = User::create($all);

            if ($create) {
                if (count($permission)!=0)
                {
                    foreach ($permission as $k => $v) {
                        UserPermissions::create(['userId'=>$create->id,'permissionsId'=>$v]);
                    }
                }
                Logger::Insert($all['name'] . 'Kullanıcı Eklendi', 'Kullanıcı');
                return redirect()->back()->with('status', 'Kullanıcı Başarı İle Eklendi');
            } else {
                return redirect()->back()->with('status', 'Kullanıcı  Eklenemedi');
            }
        }
        else
            {
                return redirect('status', 'Email Sistemde Mevcut');
            }


    }
    public function edit($id)
    {
        $c=User::where('id',$id)->count();
        if ($c !=0)
        {
            $data = User::where('id',$id)->get();
            return view('front.user.edit',['data'=>$data]);
        }
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c=User::where('id',$id)->count();
        if ($c !=0)
        {

            $all =$request->except('_token');
            $emailControl = User::where('email',$all['email'])->where('id','!=',$id)->count();
            if ($emailControl!=0)
            {
                return redirect()->back()->with('status','Email Mevcut');
            }
            elseif ($all['password'])
            {
                unset($all['password']);

            }
            else
            {
                $all['password'] = md5($all['password']);
            }

            $permission = (isset($all['permission'])) ? $all['permission'] : [];

            UserPermissions::where('userId',$id)->delete();
            if (count($permission)!=0)
            {
                foreach ($permission as $k => $v) {
                    UserPermissions::create(['userId'=>$id,'permissionsId'=>$v]);
                }
            }
            unset($all['permission']);

            $data=User::where('id',$id)->get();

            $update=User::where('id',$id)->update($all);
            if ($update)
            {
                Logger::Insert($data[0]['name'].'User Düzenlendi','Kullanıcı');
                return redirect()->back()->with('status','User Düzenlendi');
            }
        }
        else
        {
            return redirect()->back()->with('status','User Düzenlenemedi');
        }
    }
    public function delete($id)
    {
        $c=User::where('id',$id)->count();
        if ($c !=0)
        {

            $data = User::where('id',$id)->get();
            Logger::Insert($data[0]['name'].'User Silindi','Kullanıcı');
            fileUpload::directoryDelete($data[0]['photo']);
            User::where('id',$id)->delete();
            return redirect()->back();
        }
    }
    public function data(Request $request)
    {
        $table = User::query();
        $data = DataTables::of($table)
            ->addColumn('edit',function ($table){
                return '<a href="'.route('user.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('user.delete',['id'=>$table->id]).'">Sil</a>';
            })

            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }

}
