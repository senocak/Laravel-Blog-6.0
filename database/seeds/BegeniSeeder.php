<?php

use App\Begeni;
use Illuminate\Database\Seeder;

class BegeniSeeder extends Seeder{
    public function run(){
        for ($i=0; $i < 15; $i++) { 
            $randIP = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
            Begeni::create([
                "ip"=>$randIP,
                "yazi_id"=>mt_rand(1,16)
            ]);
        }
    }
}
