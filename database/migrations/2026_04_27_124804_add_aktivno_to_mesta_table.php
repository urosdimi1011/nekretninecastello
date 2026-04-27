<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('mesta', function (Blueprint $table) {
            $table->boolean('aktivan')->default(true)->after('slug');
        });
    }

    public function down()
    {
        Schema::table('mesta', function (Blueprint $table) {
            $table->dropColumn('aktivan');
        });
    }
};
