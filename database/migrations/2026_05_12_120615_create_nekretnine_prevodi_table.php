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
        Schema::create('nekretnine_prevodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nekretnina_id')
                ->constrained('nekretnine')
                ->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('naziv', 10000);
            $table->text('opis')->nullable();
            $table->unique(['nekretnina_id', 'locale']);
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
        Schema::dropIfExists('nekretnine_prevodi');
    }
};
