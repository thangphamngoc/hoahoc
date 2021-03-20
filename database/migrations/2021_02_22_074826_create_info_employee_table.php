<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('id_create')->nullable();
            $table->string('create_by')->nullable();

            $table->boolean('del_active')->default($value=true);
            $table->string('app_type'); // plus, employee,system
            $table->string('avatar')->nullable();
            $table->date('birthday');
            $table->string('code');
            $table->date('contract_date')->nullable();
            $table->string('education_level')->nullable();
            $table->string('email');
            $table->string('employee_status'); // 0 nghỉ làm, 1 // đi làm , 2 nghỉ phép , 3 tạm nghỉ
            $table->date('end_date')->nullable();
            $table->string('first_name')->nullable();
            $table->integer('phone');
            $table->string('full_name');
            $table->string('gender');
            $table->string('bank')->nullable();
            $table->string('address')->nullable();
            $table->string('url_local_avatar')->nullable();
            $table->string('facebook')->nullable();
            $table->string('verify_code_school')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_employee');
    }
}
