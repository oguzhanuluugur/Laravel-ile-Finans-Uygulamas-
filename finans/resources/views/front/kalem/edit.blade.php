@extends('layouts.app')
@section('content')
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Kalemler</h6>

        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Kalemler</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Yeni Kalem Ekle</a>
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
                        <h5 class="box-title mr-b-0">Kalem Düzenle</h5>

                        <form action="{{route('kalem.update',['id'=>$data[0]['id']])}}" enctype="multipart/form-data" method="POST" >
                            @csrf



                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="" class="col form label">Kalem Tipi</label>
                                    <div >
                                        <input type="radio" class="change-customerType" @if($data[0]['kalemTipi'] ==0) checked @endif name="kalemTipi" value="0">Gelir
                                        <br>
                                    </div>
                                    <div>
                                        <input type="radio"  class="change-customerType" @if($data[0]['kalemTipi'] ==1)  @endif  name="kalemTipi" value="1">Gider
                                        <br>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group row firma--area">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="10">Kalem Adı</label>
                                    <input class="form-control" required name="name" placeholder="Kalem Adınızı Girin" type="text" value="{{$data[0]['name']}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="10">KDV</label>
                                    <input class="form-control" required  name="kdv"  placeholder="Kdv" type="text" value="{{$data[0]['kdv']}}">
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

