<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yorum extends Model{
    public function yazi(){
        return $this->belongsTo('App\Yazi');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    /*
    //not working
    public function kategori(){
        return $this->hasOneThrough('App\Kategori','App\Yazi','id','id','','kategori_id');
    }
    */

    public function kategori(){
        return $this->hasOneThrough('App\Kategori','App\Yazi','id','id','','kategori_id');
    }
}