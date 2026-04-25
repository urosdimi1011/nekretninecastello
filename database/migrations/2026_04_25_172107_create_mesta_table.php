<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        //I don't use mesta for search because I didn't add an index to the naziv column.
        Schema::create('mesta', function (Blueprint $table) {
            $table->id();
            $table->string('naziv', 100);
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        Schema::table('nekretnine', function (Blueprint $table) {
            $table->foreignId('mesto_id')
                ->nullable()
                ->constrained('mesta')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mesta');
    }
};
