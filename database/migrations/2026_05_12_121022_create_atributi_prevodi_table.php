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
        Schema::create('atributi_prevodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atribut_id')
                ->constrained('atributi')
                ->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('naziv');
            $table->unique(['atribut_id', 'locale']);
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
        Schema::dropIfExists('atributi_prevodi');
    }
};
