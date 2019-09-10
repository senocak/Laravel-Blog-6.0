<?php
use App\Kategori;
use Illuminate\Database\Seeder;
class KategoriSeeder extends Seeder{
    public function run(){
        $json = File::get("database/veriler/kategoris.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Kategori::create(array(
            'id' => $obj->id,
            'baslik' => $obj->baslik,
            'url' => $obj->url,
            'created_at' => $obj->created_at,
            'updated_at' => $obj->updated_at,
            "resim"=>$obj->resim
          ));
        }
    }
}