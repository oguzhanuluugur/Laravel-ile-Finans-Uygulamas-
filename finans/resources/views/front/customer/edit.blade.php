@extends('layouts.app')
@section('content')
    <div class="row page-title clearfix"    >
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Müşteri Düzenle</h6>

        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Müşteriler</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">{{\App\Models\Müsteriler::getPublicName($data[0]['id'])}}</a>
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
                        <h5 class="box-title mr-b-0">Yeni Müşteri Ekle</h5>

                        <form action="{{route('customer.update',['id'=>$data[0]['id']])}}" enctype="multipart/form-data" method="POST" >
                            @csrf

                            @if($data[0]['photo']!="")
                                <div class="form-group row">
                                   <div class="col-md-12">
                                       <img src="{{asset($data[0]['photo'])}}" class="img-thumbnail" style="width: 250px" alt="">
                                   </div>
                                </div>
                                @endif
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-form-label" >Müşteri Resmi</label>
                                    <input class="form-control" name="photo" type="file">

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="" class="col form label">Müşteri Tipi</label>
                                    <div >
                                        <input type="radio" class="change-customerType" @if($data[0]['musteriTipi'] ==0) checked @endif name="musteriTipi" value="0">Bireysel
                                        <br>
                                    </div>
                                    <div>
                                        <input type="radio"  class="change-customerType"  @if($data[0]['musteriTipi'] ==1) checked @endif name="musteriTipi" value="1">Kurumsal
                                        <br>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group row firma--area" @if($data[0]['musteriTipi'] ==0)style="display: none" @endif >
                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">Firma Adı</label>
                                    <input class="form-control"  name="firmaAdı" placeholder="Firma Adınızı Girin" type="text" value="{{$data[0]['firmaAdı']}}">
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">Vergi Numarası</label>
                                    <input class="form-control"  name="vergiNumarası"  placeholder="Vergi Numaranızı Girin" type="number"value="{{$data[0]['vergiNumarası']}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">Vergi Dairesi</label>
                                    <input class="form-control"  name="vergiDairesi"  placeholder="Vergi Dairenizi Girin" type="text"value="{{$data[0]['vergiDairesi']}}">
                                </div>

                            </div>



                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="10">Ad</label>
                                    <input class="form-control"  name="name" placeholder="Adınızı Girin" type="text"value="{{$data[0]['name']}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="10">Soyad</label>
                                    <input class="form-control"  name="lastname"  placeholder="Soyadınızı Girin" type="text"value="{{$data[0]['lastname']}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label class="col-form-label" for="10">Doğum Tarihi</label>
                                    <input class="form-control"  name="dogumTarihi"  placeholder="Doğum Tarihinizi Girin" type="date"value="{{$data[0]['dogumTarihi']}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label" for="10">Tc</label>
                                    <input class="form-control"  name="tc"  placeholder="Tc Girin" type="text"value="{{$data[0]['tc']}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">Adres</label>
                                    <input class="form-control"  name="adres"  placeholder="Adresinizi" type="text"value="{{$data[0]['adres']}}">
                                </div>

                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">Telefon</label>
                                    <input class="form-control"  name="telefon"  placeholder="Telefon Numaranızı Girin" type="text"value="{{$data[0]['telefon']}}">
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="10">Email</label>
                                    <input class="form-control"  name="email"  placeholder="Emailinizi Girin" type="email" requiredvalue="{{$data[0]['email']}}">
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
    <script>
        $(".change-customerType").click(function (){
            var value=$(this).val();
            if(value==1)
            {
                $(".firma--area").show();
            }
            else
            {
                $(".firma--area").hide();
            }
        });

    </script>
@endsection
