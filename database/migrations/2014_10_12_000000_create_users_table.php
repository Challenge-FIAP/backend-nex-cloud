<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('date_accept_terms')->nullable();
            $table->string('social_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education_level')->nullable();
            $table->string('phone')->nullable();
            //$table->integer('phone')->nullable();
            $table->string('document')->nullable();
            //$table->integer('document')->nullable();
            $table->integer('address')->nullable();
            $table->integer('score')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
