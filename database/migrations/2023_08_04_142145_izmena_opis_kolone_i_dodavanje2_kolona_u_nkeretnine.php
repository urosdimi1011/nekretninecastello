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
        Schema::table('nekretnine', function (Blueprint $table) {
            $table->boolean('istaknuta');
            $table->string('opis', 10000)->change();
            $table->string('link_ka_videu')->default("https://www.youtube.com/");
            $table->string('sifra_nekretnine')->default("1/77");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nekretnine', function (Blueprint $table) {
            $table->dropColumn('istaknuta');
            $table->dropColumn('link_ka_videu');
            $table->dropColumn('sifra_nekretnine');
        });
    }
};
