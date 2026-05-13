<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipNekretninePrevodi extends Seeder
{
    public function run()
    {
        $tipovi = [
            'Stanovi' => ['en' => 'Apartments', 'ro' => 'Apartamente'],
            'Kuće' => ['en' => 'Houses', 'ro' => 'Case'],
            'Placevi' => ['en' => 'Plots', 'ro' => 'Terenuri'],
            'Poljoprivredno zamljiste' => ['en' => 'Agricultural land', 'ro' => 'Teren agricol'],
            'Lokali' => ['en' => 'Commercial spaces', 'ro' => 'Spații comerciale'],
        ];

        foreach ($tipovi as $srpskiNaziv => $prevodi) {
            $tipNekretnine = DB::table('tip_nekretnine')
                ->where('tip', $srpskiNaziv)
                ->first();

            if (!$tipNekretnine) {
                continue;
            }
            DB::table('tip_nekretnine_prevodi')->updateOrInsert(
                [
                    'tip_nekretnine_id' => $tipNekretnine->id,
                    'locale' => 'en',
                ],
                [
                    'tip' => $prevodi['en'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('tip_nekretnine_prevodi')->updateOrInsert(
                [
                    'tip_nekretnine_id' => $tipNekretnine->id,
                    'locale' => 'ro',
                ],
                [
                    'tip' => $prevodi['ro'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
