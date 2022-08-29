@extends('layouts.app')

@section('header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Kullanıcı</h6>

        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Kullanıcı</li>
            </ol>
            <div class="d-none d-md-inline-flex justify-center align-items-center"><a href="javascript: void(0);" class="btn btn-color-scheme btn-sm fs-11 fw-400 mr-l-40 pd-lr-10 mr-l-0-rtl mr-r-40-rtl hidden-xs hidden-sm ripple" target="_blank">Kullanıcı Düzenle</a>
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
                        <h5 class="box-title mr-b-0">Yeni Kullanıcı Ekle</h5>

                        <form action="{{route('user.update',['id'=>$data[0]['id']])}}" autocomplete="off" enctype="multipart/form-data" method="POST" >
                            @csrf
                            <div class="form-group row ">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="10">Kullanıcı Adı</label>
                                    <input class="form-control" required name="name" value="{{$data[0]['name']}}" type="text">
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label" for="10">Kullanıcı Email</label>
                                    <input class="form-control" required name="email" value="{{$data[0]['email']}}" placeholder="Emailinizi  Girin" type="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="col-form-label" for="10">Kullanıcı Şifre</label>
                                <input class="form-control"  name="password"  type="password">
                            </div>

                            <div class="row">
                                @foreach(\Illuminate\Support\Facades\Config::get('app.permissions') as $k=>$v)
                                    <div class="col-md-4">
                                        <input @if(\App\Models\UserPermissions::getKontrol($data[0]['id'],$k)) checked @endif type="checkbox" name="permission[]" value="{{$k}}">{{$v}}
                                    </div>

                                @endforeach
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
