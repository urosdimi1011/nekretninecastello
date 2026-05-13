<?php

namespace App\Services;

use App\Models\Mesto;
use App\Models\MestoPrevod;
use App\Models\NekretninaPrevod;
use App\Models\Nekretnine;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PrevodService
{
    public function prevediNekretninu(Nekretnine $nekretnina): void
    {
        foreach (['en', 'ro'] as $locale) {
            $tr = new GoogleTranslate();
            $tr->setSource('sr')->setTarget($locale);

            NekretninaPrevod::updateOrCreate(
                ['nekretnina_id' => $nekretnina->id, 'locale' => $locale],
                [
                    'naziv' => $tr->translate($nekretnina->naziv),
                    'opis'  => $tr->translate(strip_tags($nekretnina->opis)),
                ]
            );
        }
    }

    public function prevediMesto(Mesto $mesto): void
    {
        foreach (['en', 'ro'] as $locale) {
            $tr = new GoogleTranslate();
            $tr->setSource('sr')->setTarget($locale);

            MestoPrevod::updateOrCreate(
                ['mesto_id' => $mesto->id, 'locale' => $locale],
                ['naziv' => $tr->translate($mesto->naziv)]
            );
        }
    }
}
