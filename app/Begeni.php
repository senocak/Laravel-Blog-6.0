<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Begeni extends Model{
    public function yazi(){
        return $this->belongsTo("App\Yazi");
    }
}
