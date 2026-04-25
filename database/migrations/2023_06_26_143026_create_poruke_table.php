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
        Schema::create('poruke', function (Blueprint $table) {
            $table->id();
            $table->string("email",100);
            $table->string("ime",50);
            $table->string("prezime",100);
            $table->string("naslov",100);
            $table->string("poruka",1200);
            $table->string("telefon",11);



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
        Schema::dropIfExists('poruke');
    }
};
