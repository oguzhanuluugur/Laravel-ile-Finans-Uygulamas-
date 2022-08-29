@extends('layouts.app')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Ürünler</h6>

        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Ürünler</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Yeni Ürün Ekle</a>
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
                        <h5 class="box-title mr-b-0">Yeni Ürün Ekle</h5>

                        <form action="{{route('urun.store')}}" enctype="multipart/form-data" method="POST" >
                            @csrf
                            <div class="form-group row firma--area">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="10">Ürün Adı</label>
                                    <input class="form-control" required name="urunAdi" placeholder="Ürün Adınızı Girin" type="text">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="10">Kalem Seçiniz</label>
                                        <select name="kalemId"  class="m-b-10 form-control" data-placeholder="Kalem Seçiniz" data-toggle="select2">
                                           <option required value="">Kalem Seçiniz</option>
                                            @foreach(\App\Models\Kalem::all() as $key=>$value)
                                                <option  value="{{$value['id']}}">{{$value['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                                   <div class="row">
                                       <div class="col-md-6">
                                           <label for="" class="col-form-label">Alış Fiyatı</label>
                                           <input class="form-control" required name="alisFiyati" placeholder="Ürün Adınızı Girin" type="text">

                                   </div>
                                       <div class="col-md-6">
                                           <label for="" class="col-form-label">Satış Fiyatı</label>
                                           <input class="form-control" required name="satisFiyati" placeholder="Ürün Adınızı Girin" type="text">
                                       </div>
                            </div>

                                    <div class="col-md-12 ml-md-auto btn-list">
                                        <button class="btn btn-primary btn-rounded" type="submit">Kaydet</button>

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
@endsection
