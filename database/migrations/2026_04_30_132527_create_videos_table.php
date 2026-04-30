<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('nekretnina_id');
            $table->foreign('nekretnina_id')->references('id')->on('nekretnine')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
