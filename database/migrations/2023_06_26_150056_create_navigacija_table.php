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
        Schema::create('navigacija', function (Blueprint $table) {
            $table->id();
            $table->string("naziv");
            $table->string("url");
            $table->unsignedBigInteger("parent_id");
            $table->foreign('parent_id')->references('id')->on('navigacija');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigacija');
    }
};
