<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('dnevni_plan_slanja_nekretnina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pretplatnik_id')->constrained('pretplatnici')->cascadeOnDelete();
            $table->foreignId('nekretnina_id')->constrained('nekretnine')->cascadeOnDelete();

            $table->timestamp('planirano_za')->nullable();
            $table->timestamp('poslato_u')->nullable();

            $table->timestamps();

            $table->unique(['pretplatnik_id', 'nekretnina_id'], 'preplatnik_nekretnina_id_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dnevni_plan_slanja_nekretnina');
    }
};
