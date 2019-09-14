<?php
namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller;
use App\Kategori;
use App\User;
use App\Yazi;
use App\Yorum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class YaziController extends Controller{
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
    public function index(){
        $this->dizi["toplam_yazilar"]=count(Yazi::all());
        $this->dizi["toplam_kategoriler"]=count(Kategori::all());
        $this->dizi["toplam_kullanıcılar"]=count(User::all());
        $this->dizi["toplam_yorumlar"]=count(Yorum::whereOnay(1)->get());
        $this->dizi["onaysız_yorumlar"] = Yazi::whereHas('yorum', function($query) {$query->whereOnay(0);})->with(['yorum' => function ($query){ $query->whereOnay(0); }])->with("kategori")->with("user")->get();
        return view("admin.index", ["dizi" => $this->dizi]);
    }
    public function yazilar_index(){
        if (Auth::user()->is_admin == 1) {
            $this->dizi["yazilar"] = Yazi::with('yorum')->with("kategori")->with("user")->paginate($this->dizi["limit"]);
        } else { 
            $this->dizi["yazilar"] = Yazi::where("user_id",Auth::user()->id)->with('yorum')->with("kategori")->with("user")->paginate($this->dizi["limit"]);
        } 
        return view("admin.yazilar",["dizi" => $this->dizi]);
    }
    public function yazilar_limit($limit = null){
        if ($limit == null) $limit = $this->dizi["limit"]; 
        if (Auth::user()->is_admin == 1) {
            $this->dizi["yazilar"] = Yazi::with('yorum')->with("kategori")->with("user")->skip(0)->limit($limit)->paginate($limit);
        } else { 
            $this->dizi["yazilar"] = Yazi::where("user_id",Auth::user()->id)->with('yorum')->with("kategori")->with("user")->skip(0)->limit($limit)->paginate($limit);
        }
        $this->dizi["limit"]=$limit;
        return view("admin.yazilar",["dizi" => $this->dizi]);
    }
}
