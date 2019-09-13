<?php
namespace App\Http\Controllers;
use App\Kategori;
use App\User;
use App\Yazi;
use App\Yorum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;
use Storage; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller{
    private $return_dizi=[];
    public function __construct(){
        $this->return_dizi["kategoriler"] = Kategori::all();
        $this->return_dizi["limit"] = 5;
        $this->return_dizi["yorumlar"] = Yazi::whereHas('yorum', function($query){$query->whereOnay(1)->orderBy("id","desc")->limit($this->return_dizi["limit"]);})
                                                ->with(['yorum' => function ($query){$query->whereOnay(1)->orderBy("id","desc")->limit($this->return_dizi["limit"]);}])
                                                ->with("kategori")
                                                ->get();
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
        if(Auth::check()){ 
            $yazi = Yazi::whereUrl($url)->firstOrFail();
            $yazi_id = $yazi->id;
            $yorum = new Yorum;
            $yorum->email = Auth::user()->email;
            $yorum->isim = Auth::user()->name;
            $yorum->yorum = $request->yorum;
            $yorum->yazi_id = $yazi_id;
            $yorum->save();
        } 
        return redirect()->route("yazi",['url' => $url]);
    }
    public function profil(){
        $this->return_dizi["user"] = Auth::user();
        $this->return_dizi["user_yorumlar"] = Yazi::whereHas('yorum', function($query) {$query->whereOnay(1)->where('user_id', auth()->user()->id);})->with(['yorum' => function ($query){ $query->whereOnay(1)->where('user_id', auth()->user()->id); }])->with("kategori")->with("user")->get();
        return view('profil', ['return_dizi' => $this->return_dizi]);
    }
    public function profil_guncelle(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        $this->validate($request,array(
            'name' => 'required|max:255',
            'email'  => 'required|email'
        ));
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $password2 = $request->password2; 
        $mesaj = "";
        if ($password) {
            if ($password2) {
                if ($password == $password2) {
                    $user->password = bcrypt($password);
                    Session::flash('basarı', 'Şifre Değiştirildi.');
                }else{ 
                    Session::flash('hata', 'Şifreleriniz Eşleşmiyor.');
                }
            }else{
                Session::flash('hata', 'Yeni Şifreyi Boş Bırakmayınız');
            }
        }else{
            if ($password2) {
                Session::flash('hata', 'Şifreyi Boş Bırakmayınız');
            }
        }
        $image_name=$this->self_url(($request->name));
        if ($request->hasFile('picture')) {
            $img=$request->file('picture');
            $filename=$image_name.".".$img->getClientOriginalExtension();
            $location=public_path('images/'.$filename);
            //Image::make($img)->resize(400, null, function ($constraint) {$constraint->aspectRatio();})->save($location); 
            Image::make($img)->save($location); 
            $user->picture=$filename;
            Storage::delete(Auth::user()->picture);
        }
        $user->name = $name;
        $user->email = $email;
        $user->save();
        return redirect()->route("profil");
    }
    public function email_onayla(){
        $user = User::findOrFail(Auth::user()->id);
        $user->email_verify_token = $this->generateRandomString();
        if ($user->save()) {
            
            $data['title'] = "This is Test Mail Tuts Make";
            Mail::send('auth.verify', $data, function($message) {
                $message->to('tutsmake@gmail.com', 'Receiver Name')->subject('Tuts Make Mail');
            }); 
            if (Mail::failures()) {
                return response()->Fail('Sorry! Please try again latter');
            }else{
                return response()->success('Great! Successfully send in your mail');
            }


        } else {
            return "0";
        }
        
    }
    public function email_onayla_get($token){ 
        $user = User::where("email_verify_token",$token)->firstOrFail();
        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->save();
        }
        return redirect()->route("profil");
    }
    public function self_url($title){
        $search = array(" ","ö","ü","ı","ğ","ç","ş","/","?","&","'",",","A","B","C","Ç","D","E","F","G","Ğ","H","I","İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T","U","Ü","V","Y","Z","Q","X");
        $replace = array("-","o","u","i","g","c","s","-","","-","","","a","b","c","c","d","e","f","g","g","h","i","i","j","k","l","m","n","o","o","p","r","s","s","t","u","u","v","y","z","q","x");
        $new_text = str_replace($search,$replace,trim($title));
        return $new_text;
    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}