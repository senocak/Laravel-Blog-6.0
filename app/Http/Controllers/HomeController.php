<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Yazi;
use Illuminate\Http\Request;

class HomeController extends Controller{
    private $return_dizi=[];
    public function __construct(){
        $this->return_dizi["kategoriler"] = Kategori::all();        
    }
    public function index(){
        $this->return_dizi["yazilar"] = Yazi::whereAktif(1)->with('kategori')->with('user')->orderBy("sira","asc")->paginate(4);
        if (count($this->return_dizi["yazilar"])==0) {
            return view('errors.404');
        }else{
            return view('index', ['return_dizi' => $this->return_dizi]);
        }
    }
    public function yazi($url){
        return $url;
    }
}
