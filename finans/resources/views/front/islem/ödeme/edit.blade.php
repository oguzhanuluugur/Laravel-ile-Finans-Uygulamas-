@extends('layouts.app')
@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">İşlem</h6>

        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">İşlem</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Ödeme Düzenle</a>
            </div>
        </div>
        <!-- /.page-title-right -->
    </div>
    @if(session('status'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">{{session('status')}}</div>
            </div>
        </div>
    @endif
    <div class="widget-list">
        <div class="row">
            <div class="col-md-12 widget-holder">
                <div class="widget-bg">
                    <div class="widget-body clearfix">
                        <h5 class="box-title mr-b-0">Yeni Fatura Ekle</h5>

                        <form action="{{route('islem.update',[$data[0]['id']])}}" enctype="multipart/form-data" method="POST" >
                            @csrf
                            <div class="form-group row ">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="10">Fatura Seçiniz</label>
                                        <select name="faturaId"  class="m-b-10 form-control fatura" data-placeholder="Choose" data-toggle="select2">
                                            @foreach(\App\Models\Fatura::getList(FATURA_GIDER) as $key=>$value)
                                                <option data-musteriId="{{$value['musteriId']}}" @if($value['id']==$data[0]['faturaId']) selected @endif value="{{$value['id']}}">{{$value['faturaId']}} / {{\App\Models\Müsteriler::getPublicName($value['musteriId'])}} / {{\App\Models\Fatura::getTotal($value['id'])}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="10">Müşteri Seçiniz</label>
                                        <select name="musteriId"  class="m-b-10 form-control musteri" data-placeholder="Choose" data-toggle="select2">
                                            @foreach(\App\Models\Müsteriler::all() as $key=>$value)
                                                <option @if($value['id']==$data[0]['musteriId']) selected @endif value="{{$value['id']}}">{{\App\Models\Müsteriler::getPublicName($value['id'])}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">İşlem Tarihi </label>
                                    <input class="form-control" required name="tarih" value="{{ $data[0]['tarih'] }}" type="date ">
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="10"> Hesap</label>
                                        <select name="hesap"  class="m-b-10 form-control" data-placeholder="Choose" data-toggle="select2">
                                            <option @if($data[0]['hesap']) selected @endif value="0">Nakit</option>
                                            @foreach(\App\Models\Banka::all() as $key=>$value)
                                                <option @if($value['id']==$data[0]['hesap']) selected @endif value="{{$value['id']}}">{{$value['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="10">Ödeme Şekli</label>
                                        <select name="odemeŞekli"  class="m-b-10 form-control" data-placeholder="Choose" data-toggle="select2">
                                            <option @if($data[0]['odemeŞekli']==0) selected @endif value="0">Nakit</option>
                                            <option @if($data[0]['odemeŞekli']==1) selected @endif value="1">Banka</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="10">Fiyat</label>
                                        <input type="text" name="fiyat" class="form-control" value="{{$data[0]['fiyat']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="10">Açıklama</label>
                                    <textarea name="text" class="form-control" id="" cols="30" rows="10" >{{$data[0]['text']}}</textarea>
                                </div>
                            </div>




                            <div class="form-actions">
                                <div class="form-group row">

                                    <div class="col-md-12 ml-md-auto btn-list">
                                        <button class="btn btn-primary btn-rounded" type="submit">Kaydet</button>

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.widget-body -->
                </div>
                <!-- /.widget-bg -->
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
    <script>
        $(document).ready(function (){
            $(".fatura").change(function (){
                var musterid=$(this).find(":selected").attr('data-musteriId');
                $(".musteri").val(musterid).trigger('change');

            })
        })
@endsection
