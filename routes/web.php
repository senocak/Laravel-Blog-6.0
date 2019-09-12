<?php
Route::get('/', 'HomeController@index')->name('index');
Route::get('/kategori/{url?}', 'HomeController@kategori')->name('kategori');
Route::get('/yazar/{url?}', 'HomeController@yazar')->name('yazar');
Route::get('/yazi/{url}', 'HomeController@yazi')->name('yazi');
Route::post('/yazi/{url}', 'HomeController@yorum_ekle')->name('yorum_ekle'); 
Auth::routes(['reset' => false, 'verify' => false]);
Route::get('/profil', 'HomeController@profil')->name('profil')->middleware("auth");
Route::post('/profil', 'HomeController@profil_guncelle')->name('profil_guncelle')->middleware("auth");
//Admin Paneli
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('/', 'Admin\YaziController@index')->name('admin.index');
});