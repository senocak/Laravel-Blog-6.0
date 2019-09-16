<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller{
    private $dizi = [];
    public function __construct(){ 
        $this->middleware(function ($request, $next) {  
            if (Auth::user()->email_verified_at == null) {
                //Auth::user()->is_admin != 1 && 
                Redirect::to('/')->send();
                abort(404);
            }
            return $next($request);
        });
        $this->dizi["limit"]=10; 
    }
    public function kategoriler_index(){
        $this->dizi["kategoriler"]=Kategori::with("yazilar")->orderBy("sira","asc")->get();
        return view("admin.kategoriler", ["dizi" => $this->dizi]);
    }
    public function kategoriler_sirala(Request $request){
        foreach ($request->item as $key => $value) {
            $post = Kategori::whereId($value)->firstOrFail();
            $post->sira=($key+1);
            $post->save();
        }
        Session::flash('basarı', 'Kategoriler Sıralandı.');
        return array( 'islemSonuc' => true , 'islemMsj' => 'İçeriklerin sırala işlemi güncellendi' );
    }
}
