<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE nekretnine MODIFY COLUMN link_ka_videu VARCHAR(255) DEFAULT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE nekretnine MODIFY COLUMN link_ka_videu VARCHAR(255) NOT NULL');
    }
};
