<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBegenisTable extends Migration{
    public function up(){
        Schema::create('begenis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("ip");
            /*
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            */
            $table->unsignedBigInteger('yazi_id');
            $table->foreign('yazi_id')->references('id')->on('yazis');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('begenis');
    }
}
