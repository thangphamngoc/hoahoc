<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayAddFriendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_add_friend', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('info_nick_fb_id')->unsigned();
            $table->bigInteger('day_add_total_id')->unsigned();
            // $table->bigInteger('info_nick_fb_id')->unsigned()->nullable($value = false);
            // $table->bigInteger('day_add_id')->unsigned()->nullable($value = false);
            $table->bigInteger('id_create');
            $table->string('create_by');

            $table->boolean('del_active')->default($value=true);
            // $table->date('date_add');
            $table->integer('from_number')->nullable();
            $table->integer('to_number');
            $table->integer('from_number_group')->nullable();
            $table->integer('to_number_group');
            $table->string('image_add_day')->nullable();
            $table->string('url_local_image_day')->nullable();
            $table->string('image_add_group')->nullable();
            $table->string('url_local_image_add_group')->nullable();
            $table->string('nick_name');
            $table->foreign('info_nick_fb_id')->references('id')->on('info_nick_fb');
            $table->foreign('day_add_total_id')->references('id')->on('day_add_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_add_friend');
    }
}
