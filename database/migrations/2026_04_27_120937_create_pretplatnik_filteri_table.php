<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('pretplatnik_filteri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pretplatnik_id')
                ->constrained('pretplatnici')
                ->onDelete('cascade');
            $table->foreignId('id_tipa')
                ->constrained('tip_nekretnine')
                ->onDelete('cascade');

            // Fiksne kolone za uvek prisutne filtere
            $table->decimal('cena_min', 12, 2)->nullable();
            $table->decimal('cena_max', 12, 2)->nullable();
            $table->boolean('cena_po_metru')->default(false);
            $table->decimal('kvadratura_min', 8, 2)->nullable();
            $table->decimal('kvadratura_max', 8, 2)->nullable();

            $table->timestamps();

            // Indeksi za brže query-e u Observer-u
            $table->index(['id_tipa', 'cena_min', 'cena_max']);
            $table->index(['id_tipa', 'kvadratura_min', 'kvadratura_max']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pretplatnik_filteri');
    }
};
