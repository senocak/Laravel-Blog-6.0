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
}
