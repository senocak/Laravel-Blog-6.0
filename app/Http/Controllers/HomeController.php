<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Yazi;
use Illuminate\Http\Request;

class HomeController extends Controller{
    public function index(){
        $yazilar = Yazi::whereAktif(1)->with('kategori')->with('user')->orderBy("sira","asc")->paginate(2);
        $kategoriler = Kategori::all();
        if (count($yazilar)==0) {
            return view('errors.404');
        }else{
            return view('index', ['yazilar' => $yazilar,'kategoriler' => $kategoriler]);
        }
    }
}
