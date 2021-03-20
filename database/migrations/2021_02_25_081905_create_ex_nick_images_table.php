<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExNickImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_nick_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('info_nick_fb_id')->unsigned();
            $table->foreign('info_nick_fb_id')->references('id')->on('info_nick_fb');
            $table->bigInteger('image_spas_id')->unsigned();
            $table->foreign('image_spas_id')->references('id')->on('image_spas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ex_nick_images');
    }
}
