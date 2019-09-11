<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Yazi;
use App\Yorum;
use Illuminate\Http\Request;

class HomeController extends Controller{
    private $return_dizi=[];
    public function __construct(){
        $this->return_dizi["kategoriler"] = Kategori::all();        
    }
    public function index(){
        $this->return_dizi["yazilar"] = Yazi::whereAktif(1)->with('kategori')->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->with('user')->orderBy("sira","asc")->paginate(4);
        if (count($this->return_dizi["yazilar"])==0) {
            return view('errors.404');
        }else{
            return view('index', ['return_dizi' => $this->return_dizi]);
        }
    }
    public function yazi($url){
        $this->return_dizi["yazilar"] = Yazi::whereUrl($url)->whereAktif(1)->with('kategori')->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->with('user')->orderBy("sira","asc")->firstOrFail();
        return view('yazi', ['return_dizi' => $this->return_dizi]);
    }
    public function yorum_ekle($url, Request $request){
        $yazi = Yazi::whereUrl($url)->firstOrFail();
        $yazi_id = $yazi->id;
        $yorum = new Yorum;
        $yorum->email = $request->email;
        $yorum->isim = $request->isim;
        $yorum->yorum = $request->yorum;
        $yorum->yazi_id = $yazi_id;
        $yorum->save();
        return redirect()->route("yazi",['url' => $url]);
    }
}
