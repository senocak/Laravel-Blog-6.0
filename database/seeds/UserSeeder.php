<?php
use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder{
    public function run(){
        $json = File::get("database/veriler/users.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            User::create(array(
            'id' => $obj->id,
            'name' => $obj->name,
            'email' => $obj->email,
            'email_verified_at' => $obj->email_verified_at,
            'password' => $obj->password,
            'remember_token' => $obj->remember_token,
            'created_at' => $obj->created_at,
            'updated_at' => $obj->updated_at
          ));
        }
    }
}