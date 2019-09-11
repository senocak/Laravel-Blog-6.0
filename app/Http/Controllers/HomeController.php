<?php
namespace App\Http\Controllers;
use App\Kategori;
use App\User;
use App\Yazi;
use App\Yorum;
use Illuminate\Http\Request;
class HomeController extends Controller{
    private $return_dizi=[];
    public function __construct(){
        $this->return_dizi["kategoriler"] = Kategori::all();    
        $this->return_dizi["yorumlar"] = Yorum::whereOnay("1")->with("yazi")->limit(5)->get();        
    }
    public function index(){
        $this->return_dizi["yazilar"] = Yazi::whereAktif(1)->with('kategori')->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->with('user')->orderBy("sira","asc")->paginate(4);      
        if (count($this->return_dizi["yazilar"])==0) {
            return view('404');
        }else{
            return view('index', ['return_dizi' => $this->return_dizi]);
        }
    }
    public function kategori($url=null){
        if ($url == null) {
            return view('404');
        }
        $kategori = Kategori::whereUrl($url)->firstOrFail();
        $this->return_dizi["yazilar"] = Yazi::whereKategori_id($kategori->id)->whereAktif(1)->with('kategori')->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->with('user')->orderBy("sira","asc")->paginate(4);
        return view('index', ['return_dizi' => $this->return_dizi]);
    }
    public function yazar($id=null){
        $user = User::findOrFail($id);
        $this->return_dizi["yazilar"] = Yazi::whereUser_id($user->id)->whereAktif(1)->with('kategori')->with(["yorum" => function($q){ $q->where('yorums.onay', '=', 1); }])->with('user')->orderBy("sira","asc")->paginate(4);
        return view('index', ['return_dizi' => $this->return_dizi]);
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