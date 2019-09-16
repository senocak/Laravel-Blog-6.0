<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Image;

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
    public function kategoriler_ekle(){
        return view("admin.kategoriler_ekle", ["dizi" => $this->dizi]);
    }
    public function kategoriler_ekle_post(Request $request){
        $this->validate($request,array(
            'baslik' => 'required|max:255',
            'resim'  => 'required|image'
        ));
        $kategori = new Kategori;
        $baslik = $request->baslik; 
        $image_name=$this->self_url(($baslik));
        if ($request->hasFile('resim')) {
            $img=$request->file('resim');
            $filename=$image_name.".".$img->getClientOriginalExtension();
            $location=public_path('images/'.$filename);
            Image::make($img)->save($location); 
            $kategori->resim=$filename;
        }
        $kategori->baslik = $baslik;
        $kategori->url = $image_name;
        $kategori->save();
        return redirect()->route("admin.kategoriler.index");
    }
    public function self_url($title){
        $search = array(" ","ö","ü","ı","ğ","ç","ş","/","?","&","'",",","A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","Q","X");
        $replace = array("-","o","u","i","g","c","s","-","","-","","","a","b","c","c","d","e","f","g","g","h","i","i","j","k","l","m","n","o","o","p","r","s","s","t","u","u","v","y","z","q","x");
        $new_text = str_replace($search,$replace,trim($title));
        return $new_text;
    }
}
