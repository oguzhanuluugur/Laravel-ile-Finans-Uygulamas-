<?php

namespace App\Http\Controllers\front\fatura;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Models\FaturaIslem;
use App\Models\Logger;
use App\Models\Müsteriler;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.fatura.index');
    }
    public function create($type)
    {
       if ($type==0)
       {
           return view('front.fatura.gelir.create');
       }
       else
       {
           return view('front.fatura.gider.create');
       }
    }
    public function store(Request $request)
    {
        $type= $request->route('type');
        $all=$request->except('_token');

        $islem=$all['islem'];
        unset($all['islem']);
        $all['faturaTipi']=$type;
        $c=Fatura::where('faturaNo',$all['faturaNo'])->count();
        if ($c==0) {
            $create = Fatura::create($all);
            if ($create) {
                if ($type==FATURA_GELIR)
                {
                    Logger::Insert('Gelir Faturası Eklendi','Fatura');
                }
                else
                {
                    Logger::Insert('Gider Faturası Eklendi','Fatura');
                }
                if (count($islem) != 0) {
                    foreach ($islem as $k => $v) {
                        $islemArray = [
                            'faturaId' => $create->id,
                            'kalemId' => $v['kalemId'],
                            'miktar' => $v['gün_adet'],
                            'fiyat' => $v['tutar'],
                            'kdv' => $v['kdv'],
                            'urunId'=>$v['urunId'],
                            'araToplam' => $v['toplam_tutar'],
                            'kdvToplam' => $v['kdv_toplam'],
                            'genelToplam' => $v['genel_toplam'],
                            'text' => $v['text']
                        ];
                        FaturaIslem::create($islemArray);
                    }
                }

                return redirect()->back()->with('status', 'Fatura Eklendi');
            }

            return redirect()->back()->with('status', 'Fatura Eklenemedi');
        }
        else
        {
            return redirect()->back()->with('status','Bu fatura mevcut');
        }
    }
    public function edit($id)
    {
        $c=Fatura::where('id',$id)->count();
        if ($c!=0)
        {
            $data = Fatura::where('id',$id)->get();
            $dataIslem= FaturaIslem::where('faturaId',$id)->get();
            if ($data[0]['faturaTipi']==0)
            {
                //gelir
                return view('front.fatura.gelir.edit',['data'=>$data,'dataIslem'=>$dataIslem]);
            }
            else
            {
                return view('front.fatura.gider.edit',['data' =>$data,'dataIslem' => $dataIslem]);
            }

        }
        else
        {
            return redirect('/');
        }
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c=Fatura::where('id',$id)->count();
        if ($c!=0)
        {
            $all = $request->except('_token');
            $islem = $all['islem'];
            unset($all['islem']);
            $data=Fatura::where('id',$id)->get();
            if ($data[0]['faturaTipi']==FATURA_GELIR)
            {
                Logger::Insert($data[0]['faturaNo']."Düzenlendi",'Fatura');
            }
            else{
                Logger::Insert($data[0]['faturaNo']."Düzenlendi",'Fatura');
            }
            if (count($islem)!=0)
            {
                FaturaIslem::where('faturaId',$id)->delete();
                foreach ($islem as $k=>$v)
                {
                    $islemArray = [
                        'faturaId' => $id,
                        'kalemId' => $v['kalemId'],
                        'miktar' => $v['gün_adet'],
                        'fiyat' => $v['tutar'],
                        'kdv' => $v['kdv'],
                        'urunId'=>$v['urunId'],
                        'araToplam' => $v['toplam_tutar'],
                        'kdvToplam' => $v['kdv_toplam'],
                        'genelToplam' => $v['genel_toplam'],
                        'text' => $v['text']
                    ];
                FaturaIslem::create($islemArray);
                }
            }

            $update=Fatura::where('id',$id)->update($all);
            return redirect()->back()->with('status','Düzenlemem İşlemi Başarılı');

        }
        else
        {
            return redirect('/');
        }
    }
    public function delete($id)
    {
        $c=Fatura::where('id',$id)->count();
        if ($c !=0)
        {
            $data = Fatura::where('id',$id)->get();
            Logger::Insert($data[0]['faturaNo'].'Silindi','Fatura');
            fileUpload::directoryDelete($data[0]['photo']);
            Fatura::where('id',$id)->delete();
            return redirect()->back();
        }
    }
    public function data(Request $request)
    {
        $table = Fatura::query();
        $data = DataTables::of($table)
            ->addColumn('edit',function ($table){
                return '<a href="'.route('fatura.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('fatura.delete',['id'=>$table->id]).'">Sil</a>';
            })
            ->addColumn('musteriId',function ($table){
                return Müsteriler::getPublicName($table->musteriId);
            })
            ->editColumn('faturaTipi',function ($table){
                if ($table->faturaTipi==0){return "Gelir";}else{return "Gider";}
            })
            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }
}
