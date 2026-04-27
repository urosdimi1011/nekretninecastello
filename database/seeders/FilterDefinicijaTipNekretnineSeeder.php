<?php

namespace Database\Seeders;

use App\Models\FilterDefinicija;
use App\Models\TipNekretnine;
use Illuminate\Database\Seeder;

class FilterDefinicijaTipNekretnineSeeder extends Seeder
{
    public function run(): void
    {
        $tipovi = TipNekretnine::get()->keyBy('tip');
        $filteri = FilterDefinicija::get()->keyBy('kljuc');
        $mapa = [
            'Stanovi' => [
                'lokacija',
                'broj_soba',
                'grejanje',
                'parking',
                'garaza',
            ],
            'Kuće' => [
                'lokacija',
                'broj_soba',
                'grejanje',
                'parking',
                'garaza',
            ],
            'Placevi' => [
                'lokacija',
            ],
            'Poljoprivredno zemljiste' => [
                'lokacija',
            ],
            'Lokali' => [
                'lokacija',
                'grejanje',
                'parking',
                'garaza',
            ],
        ];

        foreach ($mapa as $nazivTipa => $kljuceviFiltera) {
            $tip = $tipovi->get($nazivTipa);

            if (!$tip) {
                continue;
            }

            $filterIds = collect($kljuceviFiltera)
                ->map(fn($kljuc) => $filteri->get($kljuc)?->id)
                ->filter()
                ->values()
                ->all();

            $tip->filteri()->syncWithoutDetaching($filterIds);
        }
    }
}
