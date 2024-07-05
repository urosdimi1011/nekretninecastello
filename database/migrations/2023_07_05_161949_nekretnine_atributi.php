<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nekretnine_atributi_vrednosi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_tip_nekretnine_atributi");
            $table->unsignedBigInteger("id_nekretnine");
            $table->string("vrednost");
            $table->foreign('id_tip_nekretnine_atributi')->references('id')->on('tip_nekretnine_atributi');
            $table->foreign('id_nekretnine')->references('id')->on('nekretnine');
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
};
