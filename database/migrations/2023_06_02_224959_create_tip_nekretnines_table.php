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
        Schema::create('tip_nekretnine', function (Blueprint $table) {
            $table->id();
            $table->string("tip");
            $table->unsignedBigInteger('id_slike');
            $table->foreign('id_slike')->references('id')->on('slike');
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
        Schema::dropIfExists('tip_nekretnines');
    }
};
