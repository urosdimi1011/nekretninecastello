<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('filter_definicije', function (Blueprint $table) {
            $table->id();
            $table->string('kljuc', 50)->unique();
            $table->string('naziv', 100);
            $table->string('tip', 50);   // raspon | kategorija | boolean | vise_izbora
            $table->json('opcije')->nullable(); //razmisliti o ovome
            $table->string('jedinica', 20)->nullable();
            $table->boolean('obavezan')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('aktivan')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('filter_definicije');
    }
};
