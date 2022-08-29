<?php

namespace App\Http\Controllers\front\banka;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\Banka;
use App\Models\Logger;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.banka.index');
    }
    public function create()
    {
        return view('front.banka.create');
    }
    public function store(Request $request)
    {

        $all = $request->except('_token');


        $create=Banka::create($all);

        if ($create)
        {
            Logger::Insert('Yeni Ekleme Yapıldı ',"Banka");
            return redirect()->back()->with('status','Banka Başarı İle Eklendi');
        }
        else
        {
            return redirect()->back()->with('status','Banka  Eklenemedi');
        }

    }
    public function edit($id)
    {
        $c=Banka::where('id',$id)->count();
        if ($c !=0)
        {
            $data = Banka::where('id',$id)->get();
            return view('front.banka.edit',['data'=>$data]);
        }
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c=Banka::where('id',$id)->count();
        if ($c !=0)
        {
            $all =$request->except('_token');
            $data=Banka::where('id',$id)->get();

            $update=Banka::where('id',$id)->update($all);
            if ($update)
            {
                Logger::Insert($data[0]['name']."Düzenlendi",'Banka');
                return redirect()->back()->with('status','Banka Düzenlendi');
            }
        }
        else
        {
            return redirect()->back()->with('status','Banka Düzenlenemedi');
        }
    }
    public function delete($id)
    {
        $c=Banka::where('id',$id)->count();
        if ($c !=0)
        {
            $data = Banka::where('id',$id)->get();
            Logger::Insert($data[0]['name']."Silindi",'Banka');
            fileUpload::directoryDelete($data[0]['photo']);
            Banka::where('id',$id)->delete();

            return redirect()->back();
        }
    }
    public function data(Request $request)
    {
        $table = Banka::query();
        $data = DataTables::of($table)
            ->addColumn('edit',function ($table){
                return '<a href="'.route('banka.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('banka.delete',['id'=>$table->id]).'">Sil</a>';
            })


            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }
}
