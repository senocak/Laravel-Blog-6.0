<?php
Route::get('/', 'HomeController@index')->name('index');
Route::get('/kategori/{url?}', 'HomeController@kategori')->name('index');
Route::get('/yazar/{url?}', 'HomeController@yazar')->name('index');
Route::get('/yazi/{url}', 'HomeController@yazi')->name('yazi');
Route::post('/yazi/{url}', 'HomeController@yorum_ekle')->name('yorum_ekle');
Auth::routes();
//Admin Paneli
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('/', 'Admin\YaziController@index')->name('admin.index');
});