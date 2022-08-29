<?php

namespace App\Http\Controllers\front\islem;

use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Models\Islem;
use App\Models\Logger;
use App\Models\Müsteriler;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.islem.index');
    }
    public function create($type)
    {
        if($type==0)
        {
            //ödeme
            return view('front.islem.ödeme.create');
        }
        else
        {
            return view('front.islem.tahsilat.create');
        }
    }
    public function edit($id)
    {
        $c=Islem::where('id',$id)->count();
        if ($c!=0)
        {
            $w=Islem::where('id',$id)->get();
            if ($w[0]['tip'] ==0)
            {
                return view('front.islem.ödeme.edit',['data'=>$w]);
            }
            else
            {
                return view('front.islem.tahsilat.edit',['data'=>$w]);
            }
        }
        else
        {
            return redirect('/');
        }
    }
    public function update(Request $request)
    {
        $id=$request->route('id');
        $all = $request->except('_token');
        $c=Islem::where('id',$id)->count();
        if ($c!=0)
        {
            $data=Islem::where('id',$id)->get();
            if ($data[0]==ISLEM_ODEME)
            {
                Logger::Insert('Ödeme Güncellendi','İslem');
            }
            else
            {
                Logger::Insert('Tahsilat Güncellendi','İslem');
            }
            Islem::where('id',$id)->update($all);
            return redirect()->back()->with('status','Ödeme güncellendi');
        }
        else
        {
            return redirect('/');
        }
    }


    public function store(Request $request)
    {
        $all=$request->except('_token');
        $type=$request->route('type');
        $all['tip']=$type;
        $create=Islem::create($all);
        if ($create)
        {
            if($type==ISLEM_ODEME)
            {
                Logger::Insert('Ödeme Yapıldı','İslem');
            }
            else{
                Logger::Insert('Tahsilat Yapıldı','İslem');
            }
            return redirect()->back()->with('status','İşlem Eklendi');
        }
        else
        {
            return redirect()->back()->with('status','İşlem Eklenemedi');
        }
    }
    public function delete($id)
    {
        $c=Islem::where('id',$id)->count();
        if ($c!=0)
        {
            $data=Islem::where('id',$id)->get();
            if ($data[0]==ISLEM_ODEME)
            {
                Logger::Insert('Ödeme Silindi','İslem');
            }
            else
            {
                Logger::Insert('Tahsilat Silindi','İslem');
            }
            Islem::where('id',$id)->delete();
            return redirect()->back()->with('status','Silindi');
        }
        else
        {
            return redirect('/');
        }
    }
    public function data(Request $request)
    {
        $table = Islem::query();
        $data = DataTables::of($table)
            ->addColumn('edit',function ($table){
                return '<a href="'.route('islem.edit',['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete',function ($table){
                return '<a href="'.route('islem.delete',['id'=>$table->id]).'">Sil</a>';
            })
            ->addColumn('faturaNo',function ($table){
                return Fatura::getNo($table->faturaId);
            })
            ->addColumn('musteriId',function ($table){
                return Müsteriler::getPublicName($table->musteriId);
            })
            ->editColumn('tip',function ($table){
                if ($table->tip==0){return "Ödeme";}else{return "Tahsilat";}
            })
            ->rawColumns(['edit','delete'])
            ->make(true);
        return $data;


    }
}
