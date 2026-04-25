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
            $table->unsignedBigInteger('id_tip_nekretnine')->default(1);
            $table->foreign('id_tip_nekretnine')->references('id')->on('tip_nekretnine');
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
            $table->dropColumn('id_tip_nekretnine');
        });
    }
};
