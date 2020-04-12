<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->integer('company_id')->default(-1);
            $table->enum('type', ['employee', 'admin', 'company'])->default('employee');
            $table->json('login_info')->nullable();
            $table->string('reset_code')->nullable();
            $table->timestamps();
        });

        DB::table('employee')->insert([
            'name' => 'Admin User', 
            'email' => 'test@test.com', 
            'password'=> Hash::make('password'), 
            'type'=>'admin'
            ]);

        Schema::table('employee', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
