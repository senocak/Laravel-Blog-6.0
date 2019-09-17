<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class KullanicilarController extends Controller{
    private $dizi = [];
    public function __construct(){ 
        $this->middleware(function ($request, $next) {  
            if (Auth::user()->email_verified_at == null) {
                /*
                //Auth::user()->is_admin != 1 && 
                Redirect::to('/')->send();
                abort(404);
                */
            }
            return $next($request);
        });
        $this->dizi["limit"]=10; 
    }
    public function kullanicilar_index(){
        $this->dizi["kullanıcılar"]=User::with("yazi")->with("yorum")->get();
        return view("admin.kullanıcılar", ["dizi"=>$this->dizi]);
    }
    public function kullanicilar_aktif_pasif($id){
        if (Auth::user()->is_admin == 1){
            $user = User::find($id);
            if ($user) {
                if ($user->email_verified_at == null) {
                    $user->email_verified_at = Carbon::now();
                    Session::flash('basarı', 'Kullanıcı Onaylandı.');
                } else {
                    $user->email_verified_at = null;
                    Session::flash('basarı', 'Kullanıcı Onayı Kaldırıldı.');
                } 
                $user->save();
            }
        }else{
            Session::flash('hata', 'Yetkisiz Kullanıcı.');
        }
        
        return redirect()->route("admin.kullanicilar.index");
    }
}
