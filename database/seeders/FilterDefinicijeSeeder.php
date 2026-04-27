<?php

namespace Database\Seeders;

use App\Models\FilterDefinicija;
use Illuminate\Database\Seeder;

class FilterDefinicijeSeeder extends Seeder
{
    public function run()
    {
        $filteri = [
            [
                'kljuc'      => 'grejanje',
                'naziv'      => 'Grejanje',
                'tip'        => FilterDefinicija::TIP_KATEGORIJA,
                'opcije'     => ['Centralno', 'Etažno', 'TA peć', 'Klima', 'Podno'],
                'jedinica'   => null,
                'obavezan'   => false,
                'sort_order' => 1,
            ],
            [
                'kljuc'      => 'parking',
                'naziv'      => 'Parking',
                'tip'        => FilterDefinicija::TIP_BOOLEAN,
                'opcije'     => null,
                'jedinica'   => null,
                'obavezan'   => false,
                'sort_order' => 2,
            ],
            [
                'kljuc'      => 'garaza',
                'naziv'      => 'Garaža',
                'tip'        => FilterDefinicija::TIP_BOOLEAN,
                'opcije'     => null,
                'jedinica'   => null,
                'obavezan'   => false,
                'sort_order' => 3,
            ],
            [
                'kljuc'      => 'sobe',
                'naziv'      => 'Broj soba',
                'tip'        => FilterDefinicija::TIP_RASPON,
                'opcije'     => [1, 2, 3, 4, 5],
                'jedinica'   => null,
                'obavezan'   => false,
                'sort_order' => 4,
            ],
            [
                'kljuc'      => 'lokacija',
                'naziv'      => 'Lokacija',
                'tip'        => FilterDefinicija::TIP_VISE_IZBORA,
                'opcije'     => null,
                'jedinica'   => null,
                'obavezan'   => false,
                'sort_order' => 5,
            ],
        ];

        foreach ($filteri as $f) {
            FilterDefinicija::firstOrCreate(
                ['kljuc' => $f['kljuc']],
                $f
            );
        }
    }
}
