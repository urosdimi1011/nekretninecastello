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
        Schema::create('pretplatnici', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->foreignId('id_tipa')->constrained('tip_nekretnine')->onDelete('cascade');
            $table->decimal('cena_min', 12, 2)->nullable();
            $table->decimal('cena_max', 12, 2)->nullable();
            $table->boolean('cena_po_metru')->default(false);
            $table->decimal('kvadratura_min', 8, 2)->nullable();
            $table->decimal('kvadratura_max', 8, 2)->nullable();
            $table->json('atributi_vrednosti')->nullable();
            $table->string('token', 64)->unique();
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
        Schema::dropIfExists('pretplatnici');
    }
};
