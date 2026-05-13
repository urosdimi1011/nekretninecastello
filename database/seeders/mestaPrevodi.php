<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class mestaPrevodi extends Seeder
{

    public function run()
    {
        $mesta = [
            'Vršac' => [
                'en' => 'Vršac',
                'ro' => 'Vârșeț',
            ],
            'Okolna mesta' => [
                'en' => 'Surrounding villages',
                'ro' => 'Satele din jur',
            ],
            'Pančevo' => [
                'en' => 'Pančevo',
                'ro' => 'Panciova',
            ],
            'Beograd' => [
                'en' => 'Belgrade',
                'ro' => 'Belgrad',
            ],
            'Tara' => [
                'en' => 'Tara',
                'ro' => 'Tara',
            ],
            'Kopaonik' => [
                'en' => 'Kopaonik',
                'ro' => 'Kopaonik',
            ],
            'Zlatibor' => [
                'en' => 'Zlatibor',
                'ro' => 'Zlatibor',
            ],
        ];
        foreach ($mesta as $srpskiNaziv => $prevodi) {
            $mesto = DB::table('mesta')
                ->where('naziv', $srpskiNaziv)
                ->first();

            if (!$mesto) {
                continue;
            }

            DB::table('mesta_prevodi')->updateOrInsert(
                [
                    'mesto_id' => $mesto->id,
                    'locale' => 'en',
                ],
                [
                    'naziv' => $prevodi['en'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('mesta_prevodi')->updateOrInsert(
                [
                    'mesto_id' => $mesto->id,
                    'locale' => 'ro',
                ],
                [
                    'naziv' => $prevodi['ro'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
