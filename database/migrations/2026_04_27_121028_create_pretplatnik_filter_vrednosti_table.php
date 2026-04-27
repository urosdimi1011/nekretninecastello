<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pretplatnik_filter_vrednosti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filter_id')
                ->constrained('pretplatnik_filteri')
                ->onDelete('cascade');
            $table->foreignId('filter_definicija_id')
                ->constrained('filter_definicije')
                ->onDelete('cascade');
            $table->string('vrednost')->nullable();
            $table->decimal('vrednost_min', 10, 2)->nullable();
            $table->decimal('vrednost_max', 10, 2)->nullable();
            $table->timestamps();

            $table->index(['filter_id', 'filter_definicija_id'], 'pfv_filter_def_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pretplatnik_filter_vrednosti');
    }
};
