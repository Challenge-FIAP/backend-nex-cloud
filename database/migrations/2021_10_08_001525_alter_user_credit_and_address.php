<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserCreditAndAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->foreignId('address_id')
                ->nullable();

            $table
                ->foreignId('credit_id')
                ->nullable();

            $table
                ->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');

            $table
                ->foreign('credit_id')
                ->references('id')
                ->on('credits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
