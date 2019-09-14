<?php
namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class YaziController extends Controller{
    public function __construct(){ 
        $this->middleware(function ($request, $next) {  
            if (Auth::user()->is_admin == 0) {
                Redirect::to('/')->send();
                abort(404);
            }
            return $next($request);
        });   
    }
    public function index(){
        return view("admin.index");
    }
}
