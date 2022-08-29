<?php

namespace App\Http\Controllers\front\customer;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Models\FaturaIslem;
use App\Models\Islem;
use App\Models\Logger;
use App\Models\Müsteriler;
use App\Models\Rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class indexController extends Controller
{
   public function index()
   {
        return view('front.customer.index');
   }
   public function create()
   {
       return view('front.customer.create');
   }
   public function store(Request $request)
   {
        $all = $request->except('_token');
        $all['photo'] = fileUpload::newUpload(rand(1,9000),'musteriler',$request->file('photo'),0);

        $create=Müsteriler::create($all);

        if ($create)
        {
            Logger::Insert('Müşteri Eklendi','Müşteri');
            return redirect()->back()->with('status','Müsteri Başarı İle Eklendi');
        }
        else
        {
            return redirect()->back()->with('status','Müsteri  Eklenemedi');
        }

   }
   public function edit($id)
   {
            $c=Müsteriler::where('id',$id)->count();
            if ($c !=0)
            {
                $data = Müsteriler::where('id',$id)->get();
                return view('front.customer.edit',['data'=>$data]);
            }
   }
   public function update(Request $request)
   {
       $id = $request->route('id');
       $c=Müsteriler::where('id',$id)->count();
       if ($c !=0)
       {
            $all =$request->except('_token');
            $data=Müsteriler::where('id',$id)->get();
            $all['photo']=fileUpload::changeUpload(rand(1,9000),'musteriler',$request->file('photo'),0,$data,'photo');
            $update=Müsteriler::where('id',$id)->update($all);
            if ($update)
            {
                Logger::Insert(Müsteriler::getPublicName($id).'Müşteri Düzenlendi','Müşteri');
                return redirect()->back()->with('status','Müsteri Düzenlendi');
            }
       }
       else
       {
           return redirect()->back()->with('status','Müsteri Düzenlendi');
       }
   }
   public function delete($id)
   {
       $c=Müsteriler::where('id',$id)->count();
       if ($c !=0)
       {
           $data = Müsteriler::where('id',$id)->get();
           Logger::Insert(Müsteriler::getPublicName($data[0]['id'])." Silindi",'Müşteri');
          fileUpload::directoryDelete($data[0]['photo']);
          Müsteriler::where('id',$id)->delete();
          return redirect()->back();
       }
   }
   public function data(Request $request)
   {
       $table = Müsteriler::query();
       $data = DataTables::of($table)
           ->addColumn('edit',function ($table){
               return '<a href="'.route('customer.edit',['id'=>$table->id]).'">Düzenle</a>';
           })
           ->addColumn('delete',function ($table){
               return '<a href="'.route('customer.delete',['id'=>$table->id]).'">Sil</a>';
           })
           ->addColumn('publicname',function ($table){
               return Müsteriler::getPublicName($table->id);
           })
           ->addColumn('bakiye',function ($table){
               $bakiye = Rapor::getMusteriBakiye($table->id);
               if ($bakiye<0)
               {
                   return '<span style="color:red"> '.$bakiye.'</span>';
               }
               elseif ($bakiye>0)
               {
                   return '<span style="color: green">+ '.$bakiye.'</span>';
               }
               else
               {
                   return $bakiye;
               }
           })
           ->addColumn('extre',function ($table){
               return '<a href="'.route('customer.extre',['id'=>$table->id]).'">Extre</a>';
           })
           ->editColumn('musteriTipi',function ($table){
               if ($table->musteriTipi ==0){return "Bireysel";}else{return "Kurumsal";}
           })
           ->rawColumns(['edit','delete','bakiye','extre'])
           ->make(true);
       return $data;



   }
   public function extre($id)
   {
       $c=Müsteriler::where('id',$id)->count();
       if($c!=0)
       {
            $data=Müsteriler::where('id',$id)->get();
            $faturaTablo=FaturaIslem::leftJoin('faturas','fatura_islems.faturaId','=','faturas.id')
                ->where('faturas.musteriId',$id)
                ->groupBy('faturas.id')
                ->orderBy('faturas.faturaTarih','desc')
                ->select(['faturas.id as id','faturas.faturaTipi as type',DB::raw('"fatura" as uType'),DB::raw('SUM(genelToplam) as fiyat'),'faturas.faturaTarih as tarih']);
            $işlemTablo=Islem::where('musteriId',$id)
                ->orderBy('tarih','desc')
                ->select(['id','tip as type',DB::raw('"islem" as uType'),'fiyat','tarih']);

            $viewdata=$faturaTablo->union($işlemTablo)
                ->orderBy('tarih','desc')
                ->get();



            return view('front.customer.extre',['data'=>$data,'viewData'=>$viewdata]);
       }
       else
       {
           return redirect('/');
       }
   }
}
