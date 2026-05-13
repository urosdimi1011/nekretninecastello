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
        Schema::create('tip_nekretnine_prevodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tip_nekretnine_id')
                ->constrained('tip_nekretnine')
                ->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('tip');
            $table->unique(['tip_nekretnine_id', 'locale']);
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
        Schema::dropIfExists('tip_nekretnine_prevodi');
    }
};
