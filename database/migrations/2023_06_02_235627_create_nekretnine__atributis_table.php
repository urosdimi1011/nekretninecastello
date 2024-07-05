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
        Schema::create('tip_nekretnine_atributi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_tip_nekretnine");
            $table->unsignedBigInteger("id_atributa");
            $table->foreign('id_tip_nekretnine')->references('id')->on('tip_nekretnine');
            $table->foreign('id_atributa')->references('id')->on('atributi');
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
        Schema::dropIfExists('nekretnine_atributi');
    }
};
