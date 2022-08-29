<?php

namespace App\Http\Controllers\front\urun;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;

use App\Models\FaturaIslem;
use App\Models\Logger;
use App\Models\Ürün;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;



class indexController extends Controller
{
    public function index()
    {
        return view('front.urun.index');
    }
    public function create()
    {
        return view('front.urun.create');
    }
    public function store(Request $request)
    {
        $all = $request->except('_token');


        $create=Ürün::create($all);

        if ($create)
        {
            Logger::Insert($all['urunAdi'].'Ürün Eklendi','urun');
            return redirect()->back()->with('status','Ürün Başarı İle Eklendi');
        }
        else
        {
            return redirect()->back()->with('status','Ürün  Eklenemedi');
        }

    }
    public function edit($id)
    {
        $c=Ürün::where('id',$id)->count();
        if ($c !=0)
        {
            $data = Ürün::where('id',$id)->get();
            return view('front.urun.edit',['data'=>$data]);
        }
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c=Ürün::where('id',$id)->count();
        if ($c !=0)
        {

            $all =$request->except('_token');
            $data=Ürün::where('id',$id)->get();

            $update=Ürün::where('id',$id)->update($all);
            if ($update)
            {
                Logger::Insert($data[0]['urunAdi'].'Ürün Düzenlendi','urun');
                return redirect()->back()->with('status','Ürün Düzenlendi');
            }
        }
        else
        {
            return redirect()->back()->with('status','Ürün Düzenlenemedi');
        }
    }
    public function delete($id)
    {
        $c=Ürün::where('id',$id)->count();
        if ($c !=0)
        {

            $data = Ürün::where('id',$id)->get();
            Logger::Insert($data[0]['urunAdi'].'Ürün Silindi','urun');
            fileUpload::directoryDelete($data[0]['photo']);
            Ürün::where('id',$id)->delete();
            return redirect()->back();
        }
    }
    public function data(Request $request)
    {
        $table = Ürün::query();
        $data = DataTables::of($table)
            ->addColumn('edit',function ($table){
                return '<a href="'.route('urun.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('urun.delete',['id'=>$table->id]).'">Sil</a>';
            })
            ->addColumn('stok',function ($table){
                $girdi = FaturaIslem::leftJoin('faturas','fatura_islems.faturaId','faturas.id')
                    ->where('fatura_islems.urunId',$table->id)
                    ->where('faturas.faturaTipi',FATURA_GIDER)
                    ->sum('fatura_islems.miktar');
                $çikti = FaturaIslem::leftJoin('faturas','fatura_islems.faturaId','faturas.id')
                    ->where('fatura_islems.urunId',$table->id)
                    ->where('faturas.faturaTipi',FATURA_GELIR)
                    ->sum('fatura_islems.miktar');
                return $girdi-$çikti;
            })
            ->editColumn('kalemTipi',function ($table){
                if ($table->kalemTipi ==0){return "Gelir";}else{return "Gider";}
            })
            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }


}
