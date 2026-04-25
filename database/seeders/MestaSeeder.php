<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MestaSeeder extends Seeder
{

    public function run()
    {
        $mesta = [
            ['naziv' => 'Vršac',           'slug' => 'vrsac'],
            ['naziv' => 'Okolna mesta',       'slug' => 'okolina'],
            ['naziv' => 'Pančevo',        'slug' => 'pančevo'],
            ['naziv' => 'Beograd',          'slug' => 'beograd'],
            ['naziv' => 'Tara',           'slug' => 'tara'],
            ['naziv' => 'Kopaonik',        'slug' => 'kopaonik'],
            ['naziv' => 'Zlatibor',        'slug' => 'zlatibor'],
        ];

        foreach ($mesta as $m) {
            \App\Models\Mesto::firstOrCreate(['slug' => $m['slug']], $m);
        }
    }
}
