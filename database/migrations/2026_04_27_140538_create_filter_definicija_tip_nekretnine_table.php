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
        Schema::create('filter_definicija_tip_nekretnine', function (Blueprint $table) {
            $table->id();

            $table->foreignId('filter_definicija_id')
                ->constrained('filter_definicije')
                ->cascadeOnDelete();

            $table->foreignId('tip_nekretnine_id')
                ->constrained('tip_nekretnine')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['filter_definicija_id', 'tip_nekretnine_id'], 'filter_tip_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filter_definicija_tip_nekretnine');
    }
};
