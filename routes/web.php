<?php
Route::get('/', 'HomeController@index')->name('index');
Route::get('/kategori/{url?}', 'HomeController@kategori')->name('kategori');
Route::get('/yazar/{url?}', 'HomeController@yazar')->name('yazar');
Route::get('/yazi/{url}', 'HomeController@yazi')->name('yazi');
Route::post('/yazi/{url}', 'HomeController@yorum_ekle')->name('yorum_ekle'); 
Route::get('/yazi/begen/{url}', "HomeController@yazilar_begen")->name("yazilar.begen");
Auth::routes(['reset' => false, 'verify' => false]);
Route::get('/profil', 'HomeController@profil')->name('profil')->middleware("auth");
Route::post('/profil', 'HomeController@profil_guncelle')->name('profil_guncelle')->middleware("auth");
Route::post('/profil/email_onayla', 'HomeController@email_onayla')->name('email_onayla')->middleware("auth");
Route::get('/profil/email_onayla/{token}', 'HomeController@email_onayla_get')->name('email_onayla_get');
//Admin Paneli
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('/', 'Admin\YaziController@index')->name('admin.index');
    Route::get('/yazilar', 'Admin\YaziController@yazilar_index')->name('admin.yazilar.index');
    Route::get('/yazilar/limit/{limit?}', 'Admin\YaziController@yazilar_limit')->name('admin.yazilar.index.limit');
    Route::get('/yazilar/duzenle/{id}', 'Admin\YaziController@yazilar_duzenle')->name('admin.yazilar.duzenle');
    Route::post('/yazilar/duzenle/{id}', 'Admin\YaziController@yazilar_duzenle_post')->name('admin.yazilar.duzenle.post');
    Route::get('/yazilar/sil/{id}', 'Admin\YaziController@yazilar_sil')->name('admin.yazilar.sil');
    Route::get('/yazilar/ekle', 'Admin\YaziController@yazilar_ekle')->name('admin.yazilar.ekle');
    Route::post('/yazilar/ekle', 'Admin\YaziController@yazilar_ekle_post')->name('admin.yazilar.ekle.post');
    Route::post("/yazilar/sirala", "Admin\YaziController@yazilar_sirala")->name("admin.yazilar.sirala");
    //Kategoriler
    Route::get('/kategoriler', 'Admin\KategoriController@kategoriler_index')->name('admin.kategoriler.index');
    Route::post("/kategoriler/sirala", "Admin\KategoriController@kategoriler_sirala")->name("admin.kategoriler.sirala");
    Route::get('/kategoriler/ekle', 'Admin\KategoriController@kategoriler_ekle')->name('admin.kategoriler.ekle');
    Route::post('/kategoriler/ekle', 'Admin\KategoriController@kategoriler_ekle_post')->name('admin.kategoriler.ekle.post');
    Route::get('/kategoriler/duzenle/{id}', 'Admin\KategoriController@kategoriler_duzenle')->name('admin.kategoriler.duzenle');
    Route::post('/kategoriler/duzenle/{id}', 'Admin\KategoriController@kategoriler_duzenle_post')->name('admin.kategoriler.duzenle.post');
    Route::get('/kategoriler/sil/{id}', 'Admin\KategoriController@kategoriler_sil')->name('admin.kategoriler.sil');
    
});