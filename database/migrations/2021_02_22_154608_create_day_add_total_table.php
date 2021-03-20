<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayAddTotalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_add_total', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('info_employee_id')->unsigned();
            $table->bigInteger('id_create');
            $table->string('create_by');

            $table->boolean('del_active')->default($value=true);
            $table->date('date_add');
            $table->integer('total_day')->nullable();
            $table->string('total_add_group')->nullable();
            $table->foreign('info_employee_id')->references('id')->on('info_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_add_total');
    }
}
