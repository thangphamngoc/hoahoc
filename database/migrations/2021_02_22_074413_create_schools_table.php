<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('id_create')->nullable();
            $table->string('create_by')->nullable();

            $table->boolean('del_active')->default($value=true);
            $table->boolean('school_active')->default($value=true);
            $table->string('school_avatar');
            $table->string('school_address');
            $table->string('school_code');
            $table->string('school_description');
            $table->string('school_email');
            $table->string('school_local_avatar');
            $table->string('school_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
