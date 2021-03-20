<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoNickFbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_nick_fb', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('id_create');
            $table->string('create_by');

            $table->boolean('del_active')->default($value=true);
            $table->string('nick_name');
            $table->string('url_fb');
            $table->string('username_fb');
            $table->string('password_fb');
            $table->string('image_fb')->nullable();
            $table->string('url_local_image')->nullable();
            $table->string('status_nick'); //0 chết // 1 sống //2 đầy
            $table->integer('number_friend')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_nick_fb');
    }
}
