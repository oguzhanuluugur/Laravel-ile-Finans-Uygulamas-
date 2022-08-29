<?php

namespace App\Http\Controllers\front\kalem;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\Kalem;

use App\Models\Logger;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.kalem.index');
    }
    public function create()
    {
        return view('front.kalem.create');
    }
    public function store(Request $request)
    {
        $all = $request->except('_token');


        $create=Kalem::create($all);

        if ($create)
        {
            Logger::Insert($all['name'].'Kalemi Eklendi','Kalem');
            return redirect()->back()->with('status','Kalem Başarı İle Eklendi');
        }
        else
        {
            return redirect()->back()->with('status','Kalem  Eklenemedi');
        }

    }
    public function edit($id)
    {
        $c=Kalem::where('id',$id)->count();
        if ($c !=0)
        {
            $data = Kalem::where('id',$id)->get();
            return view('front.kalem.edit',['data'=>$data]);
        }
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c=Kalem::where('id',$id)->count();
        if ($c !=0)
        {

            $all =$request->except('_token');
            $data=Kalem::where('id',$id)->get();

            $update=Kalem::where('id',$id)->update($all);
            if ($update)
            {
                Logger::Insert($data[0]['name'].'Kalemi Düzenlendi','Kalem');
                return redirect()->back()->with('status','Kalem Düzenlendi');
            }
        }
        else
        {
            return redirect()->back()->with('status','Kalem Düzenlenemedi');
        }
    }
    public function delete($id)
    {
        $c=Kalem::where('id',$id)->count();
        if ($c !=0)
        {

            $data = Kalem::where('id',$id)->get();
            Logger::Insert($data[0]['name'].'Kalemi Silindi','Kalem');
            fileUpload::directoryDelete($data[0]['photo']);
            Kalem::where('id',$id)->delete();
            return redirect()->back();
        }
    }
    public function data(Request $request)
    {
        $table = Kalem::query();
        $data = DataTables::of($table)
            ->addColumn('edit',function ($table){
                return '<a href="'.route('kalem.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('kalem.delete',['id'=>$table->id]).'">Sil</a>';
            })

            ->editColumn('kalemTipi',function ($table){
                if ($table->kalemTipi ==0){return "Gelir";}else{return "Gider";}
            })
            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }
}
