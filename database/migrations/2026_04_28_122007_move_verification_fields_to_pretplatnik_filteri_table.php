<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pretplatnik_filteri', function (Blueprint $table) {
            $table->string('token', 64)->nullable()->unique()->after('pretplatnik_id');
            $table->timestamp('verified_at')->nullable()->after('token');
        });

        Schema::table('pretplatnici', function (Blueprint $table) {
            if (Schema::hasColumn('pretplatnici', 'token')) {
                $table->dropColumn('token');
            }

            if (Schema::hasColumn('pretplatnici', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });
    }

    public function down()
    {
        Schema::table('pretplatnici', function (Blueprint $table) {
            $table->string('token', 64)->nullable();
            $table->timestamp('verified_at')->nullable();
        });

        Schema::table('pretplatnik_filteri', function (Blueprint $table) {
            $table->dropUnique(['token']);
            $table->dropColumn(['token', 'verified_at']);
        });
    }
};
