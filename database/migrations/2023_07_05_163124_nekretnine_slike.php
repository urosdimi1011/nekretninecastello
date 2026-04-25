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
        Schema::create('nekretnine_slike', function (Blueprint $table) {
            $table->unsignedBigInteger("id_nekretnine");
            $table->unsignedBigInteger("id_slike");
            $table->index(['id_nekretnine', 'id_slike']);
            $table->foreign('id_slike')->references('id')->on('slike');
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
