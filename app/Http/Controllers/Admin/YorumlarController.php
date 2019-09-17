<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Yorum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class YorumlarController extends Controller{
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
        $this->dizi["limit"]=20; 
    }
    public function yorumlar_index(){
        $this->dizi["yorumlar"]=Yorum::with("yazi")->with("user")->paginate($this->dizi["limit"]); 
        return view("admin.yorumlar", ["dizi"=>$this->dizi]);
    }
    public function yorumlar_limit($limit = null){
        if ($limit == null || !is_numeric($limit)) $limit = $this->dizi["limit"];
        $this->dizi["limit"]=$limit;
        $this->dizi["yorumlar"]=Yorum::with("yazi")->with("user")->paginate($this->dizi["limit"]); 
        return view("admin.yorumlar",["dizi" => $this->dizi]);
    }
    public function yorumlar_aktif_pasif($id){
        $yorum = Yorum::find($id);
        if ($yorum != "") {
            if ($yorum->onay == "1") {
                $yorum->onay = "0";
            }else{
                $yorum->onay = "1";
            }
            $yorum->save();
        }
        return redirect()->route("admin.yorumlar.index");
    }
}