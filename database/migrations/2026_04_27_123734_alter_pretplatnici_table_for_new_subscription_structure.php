<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('pretplatnici', function (Blueprint $table) {
            $table->dropForeign(['id_tipa']);
            $table->dropColumn([
                'id_tipa',
                'cena_min',
                'cena_max',
                'cena_po_metru',
                'kvadratura_min',
                'kvadratura_max',
                'atributi_vrednosti',
            ]);

            $table->timestamp('verified_at')->nullable()->after('token');
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::table('pretplatnici', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropColumn('verified_at');

            $table->foreignId('id_tipa')->constrained('tip_nekretnine')->onDelete('cascade');
            $table->decimal('cena_min', 12, 2)->nullable();
            $table->decimal('cena_max', 12, 2)->nullable();
            $table->boolean('cena_po_metru')->default(false);
            $table->decimal('kvadratura_min', 8, 2)->nullable();
            $table->decimal('kvadratura_max', 8, 2)->nullable();
            $table->json('atributi_vrednosti')->nullable();
        });
    }
};
