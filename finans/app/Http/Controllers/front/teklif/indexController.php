<?php

namespace App\Http\Controllers\front\teklif;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\Kalem;
use App\Models\Logger;
use App\Models\Müsteriler;
use App\Models\Teklif;
use App\Models\TeklifIcerik;
use App\Models\Ürün;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.teklif.index');
    }
    public function create()
    {
        return view('front.teklif.create');
    }
    public function store(Request $request)
    {
        $request->validate(['fiyat'=>'required|regex:/^\d+(\.\d{1,2})?$/','musteriId'=>'required|integer','urunler'=>'required']);
        $all = $request->except('_token');
        $urunler=($all['urunler']);
        unset($all['urunler']);
        $all['userId'] =Auth::id();

        $create=Teklif::create($all);

        if ($create)
        {
            foreach ($urunler as $k=>$v)
            {
                TeklifIcerik::create(['teklifId'=>$create->id,'urunId'=>$v['urunId'],'adet'=>$v['adet']]);
            }
            Logger::Insert('Teklif Eklendi','Teklid');
            return redirect()->back()->with('status','Teklif Başarı İle Eklendi');
        }
        else
        {
            return redirect()->back()->with('status','Kalem  Eklenemedi');
        }

    }
    public function edit($id)
    {
        $c=Teklif::where('id',$id)->count();
        if ($c !=0)
        {
            $data = Teklif::where('id',$id)->get();
            $content =TeklifIcerik::where('teklifId',$id)->get();
            return view('front.teklif.edit',['data'=>$data,'content'=>$content]);
        }
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c=Teklif::where('id',$id)->count();
        if ($c !=0)
        {
            $request->validate(['fiyat'=>'required|regex:/^\d+(\.\d{1,2})?$/','musteriId'=>'required|integer','urunler'=>'required']);
            $all =$request->except('_token');
            $urunler=$all['urunler'];
            unset($all['urunler']);
           /*Teklif İçeriği*/
            TeklifIcerik::where('teklifId',$id)->delete();
            foreach ($urunler as $k => $v)
            {
                TeklifIcerik::create(['teklifId'=>$id,'urunId'=>$v['urunId'],'adet'=>$v['adet']]);
            }


            $update=Teklif::where('id',$id)->update($all);
            if ($update)
            {
                Logger::Insert('Teklif Düzenlendi','Teklif');
                return redirect()->back()->with('status','Teklif Düzenlendi');
            }
        }
        else
        {
            return redirect()->back()->with('status','Teklif Düzenlenemedi');
        }
    }
    public function delete($id)
    {
        $c=Teklif::where('id',$id)->count();
        if ($c !=0)
        {
            Logger::Insert('Teklif Silindi','Teklif');
            Teklif::where('id',$id)->delete();
            TeklifIcerik::where('teklifId',$id)->delete();
            return redirect()->back();
        }
        else
        {
            return redirect('/');
        }
    }
    public function data(Request $request)
    {
        $table = Teklif::query();
        $data = DataTables::of($table)
            ->addColumn('musteri',function ($table){
                return Müsteriler::getPublicName($table->musteriId);
            })
            ->addColumn('edit',function ($table){
                return '<a href="'.route('teklif.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('teklif.delete',['id'=>$table->id]).'">Sil</a>';
            })

            ->editColumn('status',function ($table){
                return($table->status==0) ? "Bekleyen" : "Onaylanmış";
            })
            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }
}
