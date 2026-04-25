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
        Schema::create('nekretnine', function (Blueprint $table) {
            $table->id();
            $table->string("naziv",100);
            $table->string("opis",1000);
            $table->decimal("cena",10,2);
            $table->unsignedBigInteger('id_slike');
            $table->foreign('id_slike')->references('id')->on('slike');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nekretnine');
    }
};
