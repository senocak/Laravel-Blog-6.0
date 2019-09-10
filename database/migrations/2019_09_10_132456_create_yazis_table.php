<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYazisTable extends Migration{
    public function up(){
        Schema::create('yazis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("baslik");
            $table->string("url");
            $table->text("icerik");
            $table->unsignedBigInteger("kategori_id");
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text("etiketler");
            $table->integer("aktif")->default(1); //1->aktif, 0->pasif
            $table->integer("sira")->default(0);
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('yazis');
    }
}
