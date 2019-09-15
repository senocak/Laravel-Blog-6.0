<?php
namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller;
use App\Kategori;
use App\User;
use App\Yazi;
use App\Yorum;
use Illuminate\Http\Request;
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
            $this->dizi["yazilar"] = Yazi::with('yorum')->with("kategori")->with("user")->orderBy("created_at","asc")->paginate($this->dizi["limit"]);
        } else { 
            $this->dizi["yazilar"] = Yazi::where("user_id",Auth::user()->id)->with('yorum')->with("kategori")->with("user")->orderBy("created_at","asc")->paginate($this->dizi["limit"]);
        } 
        return view("admin.yazilar",["dizi" => $this->dizi]);
    }
    public function yazilar_limit($limit = null){
        if ($limit == null) $limit = $this->dizi["limit"]; 
        if (Auth::user()->is_admin == 1) {
            $this->dizi["yazilar"] = Yazi::with('yorum')->with("kategori")->with("user")->skip(0)->limit($limit)->orderBy("created_at","asc")->paginate($limit);
        } else { 
            $this->dizi["yazilar"] = Yazi::where("user_id",Auth::user()->id)->with('yorum')->with("kategori")->with("user")->skip(0)->limit($limit)->orderBy("created_at","asc")->paginate($limit);
        }
        $this->dizi["limit"]=$limit;
        return view("admin.yazilar",["dizi" => $this->dizi]);
    }
    public function yazilar_duzenle($id){
        $this->dizi["yazi"] = Yazi::findOrFail($id);
        $user_id = Auth::user()->id;
        if ($user_id != $this->dizi["yazi"]->user_id) {
            return redirect()->route("admin.yazilar.index");
        }
        $this->dizi["kategoriler_select"] = Kategori::pluck('baslik', 'id'); 
        return view("admin.yazilar_duznle",["dizi" => $this->dizi]);
    }
    public function yazilar_duzenle_post($id, Request $request){
        $request->validate([
            'baslik' => 'required|max:255',
            'icerik' => 'required',
            'kategori_id' => 'required',
        ]);
        $baslik = $request->baslik;
        $icerik = $request->icerik;
        $kategori_id = $request->kategori_id;
        $etiketler = $request->etiketler; 
        $aktif = $request->aktif ? "1" : "0"; 
        $yazi = Yazi::findOrFail($id);
        $yazi->baslik = $baslik;
        $yazi->icerik = $icerik;
        $yazi->kategori_id = $kategori_id;
        $yazi->etiketler = $etiketler;
        $yazi->aktif = $aktif;
        $yazi->url = $this->self_url($baslik);
        $yazi->user_id = Auth::user()->id;
        $yazi->save();
        return redirect()->route("admin.yazilar.index");
    }
    public function self_url($title){
        $search = array(" ","ö","ü","ı","ğ","ç","ş","/","?","&","'",",","A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","Q","X");
        $replace = array("-","o","u","i","g","c","s","-","","-","","","a","b","c","c","d","e","f","g","g","h","i","i","j","k","l","m","n","o","o","p","r","s","s","t","u","u","v","y","z","q","x");
        $new_text = str_replace($search,$replace,trim($title));
        return $new_text;
    }
}
