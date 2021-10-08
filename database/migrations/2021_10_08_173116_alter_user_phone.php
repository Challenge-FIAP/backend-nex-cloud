<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserPhone extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->foreignId('phone_id')
                ->nullable();

            $table
                ->foreign('phone_id')
                ->references('id')
                ->on('phones')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        //
    }
}
