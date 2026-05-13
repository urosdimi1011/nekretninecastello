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
        Schema::create('mesta_prevodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesto_id')
                ->constrained('mesta')
                ->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('naziv');
            $table->unique(['mesto_id', 'locale']);
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
        Schema::dropIfExists('mesta_prevodi');
    }
};
