<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['namespace'=>'front','middleware'=>['auth']],function (){
    Route::group(['namespace'=>'profil','as'=>'profil.','prefix' => 'profil'],function (){
        Route::get('/',[App\Http\Controllers\front\profil\indexController::class,'index'])->name('index');
        Route::post('/',[App\Http\Controllers\front\profil\indexController::class,'update'])->name('update');
    });


    Route::group(['namespace'=>'home','as'=>'home.'],function (){
        Route::get('/',[\App\Http\Controllers\front\home\indexController::class,'index'])->name('index');

    });
    Route::group(['namespace'=>'customer','as'=>'customer.','prefix'=>'customer','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\customer\indexController::class,'index'])->name('index');
        Route::get('/olustur',[\App\Http\Controllers\front\customer\indexController::class,'create'])->name('create');
        Route::post('/olustur',[\App\Http\Controllers\front\customer\indexController::class,'store'])->name('store');
        Route::get('/düzenle{id}',[\App\Http\Controllers\front\customer\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle{id}',[\App\Http\Controllers\front\customer\indexController::class,'update'])->name('update');
        Route::get('/delete{id}',[\App\Http\Controllers\front\customer\indexController::class,'delete'])->name('delete');
        Route::get('/extre{id}',[\App\Http\Controllers\front\customer\indexController::class,'extre'])->name('extre');
        Route::post('/data',[\App\Http\Controllers\front\customer\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'kalem','as'=>'kalem.','prefix'=>'kalem','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\kalem\indexController::class,'index'])->name('index');
        Route::get('/olustur',[\App\Http\Controllers\front\kalem\indexController::class,'create'])->name('create');
        Route::post('/olustur',[\App\Http\Controllers\front\kalem\indexController::class,'store'])->name('store');
        Route::get('/düzenle{id}',[\App\Http\Controllers\front\kalem\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle{id}',[\App\Http\Controllers\front\kalem\indexController::class,'update'])->name('update');
        Route::get('/delete{id}',[\App\Http\Controllers\front\kalem\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\kalem\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'fatura','as'=>'fatura.','prefix'=>'fatura','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\fatura\indexController::class,'index'])->name('index');
        Route::get('/olustur/{type}',[\App\Http\Controllers\front\fatura\indexController::class,'create'])->name('create');
        Route::post('/olustur/{type}',[\App\Http\Controllers\front\fatura\indexController::class,'store'])->name('store');
        Route::get('/düzenle/{id}',[\App\Http\Controllers\front\fatura\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle/{id}',[\App\Http\Controllers\front\fatura\indexController::class,'update'])->name('update');
        Route::get('/delete/{id}',[\App\Http\Controllers\front\fatura\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\fatura\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'banka','as'=>'banka.','prefix'=>'banka','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\banka\indexController::class,'index'])->name('index');
        Route::get('/olustur',[\App\Http\Controllers\front\banka\indexController::class,'create'])->name('create');
        Route::post('/olustur',[\App\Http\Controllers\front\banka\indexController::class,'store'])->name('store');
        Route::get('/düzenle{id}',[\App\Http\Controllers\front\banka\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle{id}',[\App\Http\Controllers\front\banka\indexController::class,'update'])->name('update');
        Route::get('/delete{id}',[\App\Http\Controllers\front\banka\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\banka\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'islem','as'=>'islem.','prefix'=>'islem','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\islem\indexController::class,'index'])->name('index');
        Route::get('/olustur/{type}',[\App\Http\Controllers\front\islem\indexController::class,'create'])->name('create');
        Route::post('/olustur/{type}',[\App\Http\Controllers\front\islem\indexController::class,'store'])->name('store');
        Route::get('/düzenle/{id}',[\App\Http\Controllers\front\islem\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle/{id}',[\App\Http\Controllers\front\islem\indexController::class,'update'])->name('update');
        Route::get('/delete/{id}',[\App\Http\Controllers\front\islem\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\islem\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'urun','as'=>'urun.','prefix'=>'urun','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\urun\indexController::class,'index'])->name('index');
        Route::get('/olustur',[\App\Http\Controllers\front\urun\indexController::class,'create'])->name('create');
        Route::post('/olustur',[\App\Http\Controllers\front\urun\indexController::class,'store'])->name('store');
        Route::get('/düzenle{id}',[\App\Http\Controllers\front\urun\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle{id}',[\App\Http\Controllers\front\urun\indexController::class,'update'])->name('update');
        Route::get('/delete{id}',[\App\Http\Controllers\front\urun\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\urun\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'user','as'=>'user.','prefix'=>'user','middleware' => ['PermissionControl']],function (){
        Route::get('/',[\App\Http\Controllers\front\user\indexController::class,'index'])->name('index');
        Route::get('/olustur',[\App\Http\Controllers\front\user\indexController::class,'create'])->name('create');
        Route::post('/olustur',[\App\Http\Controllers\front\user\indexController::class,'store'])->name('store');
        Route::get('/düzenle{id}',[\App\Http\Controllers\front\user\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle{id}',[\App\Http\Controllers\front\user\indexController::class,'update'])->name('update');
        Route::get('/delete{id}',[\App\Http\Controllers\front\user\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\user\indexController::class,'data'])->name('data');

    });
    Route::group(['namespace'=>'teklif','as'=>'teklif.','prefix'=>'teklif'],function (){
        Route::get('/',[\App\Http\Controllers\front\teklif\indexController::class,'index'])->name('index');
        Route::get('/olustur',[\App\Http\Controllers\front\teklif\indexController::class,'create'])->name('create');
        Route::post('/olustur',[\App\Http\Controllers\front\teklif\indexController::class,'store'])->name('store');
        Route::get('/düzenle{id}',[\App\Http\Controllers\front\teklif\indexController::class,'edit'])->name('edit');
        Route::post('/düzenle{id}',[\App\Http\Controllers\front\teklif\indexController::class,'update'])->name('update');
        Route::get('/delete{id}',[\App\Http\Controllers\front\teklif\indexController::class,'delete'])->name('delete');
        Route::post('/data',[\App\Http\Controllers\front\teklif\indexController::class,'data'])->name('data');

    });

});
