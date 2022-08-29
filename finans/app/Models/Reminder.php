<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    static function FaturaHatırlatıcı()
    {
        $returnArray=[];
        if (Fatura::count() !=0)
        {
            $list = Fatura::all();
            foreach ($list as $k=>$v)
            {
                if ($v['faturaTipi'] ==0)
                {
                    // gelir faturası
                    $c=Islem::where('tip',ISLEM_TAHSILAT)->where('faturaId',$v['id'])->count();
                    $type="Gelir Faturası";
                    $uri=route('islem.create',ISLEM_TAHSILAT);
                }
                else
                {
                    // gider fatura
                    $c=Islem::where('tip',ISLEM_ODEME)->where('faturaId',$v['id'])->count();
                    $type="Gider Faturası";
                    $uri=route('islem.create',ISLEM_ODEME);
                }
                if ($c==0)
                {
                    $returnArray[$k]['name']=$v['faturaNo']." - ".$type;
                    $returnArray[$k]['musteriId']=$v['musteriId'];
                    $returnArray[$k]['fiyat']=Fatura::getTotal($v['id']);
                    $returnArray[$k]['uri']=$uri;
                }
            }
        }
      return $returnArray;
    }
}
