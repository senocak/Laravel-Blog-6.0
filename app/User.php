<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['name', 'email', 'password','username',];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];
    public function yazi(){
        return $this->hasMany("App\Yazi");
    }
    public function yorum(){
        return $this->hasMany('App\Yorum');
    }
}