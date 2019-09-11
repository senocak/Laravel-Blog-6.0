<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yazi extends Model{
    public function kategori(){
        return $this->belongsTo('App\Kategori');
    }
    public function user(){
        return $this->belongsTo("App\User");
    }
    public function yorum()    {
        return $this->hasMany('App\Yorum');
    }
}
