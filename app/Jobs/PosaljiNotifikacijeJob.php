<?php

namespace App\Jobs;

use App\Models\FilterDefinicija;
use App\Models\Nekretnine;
use App\Models\PretplatnikFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PosaljiNotifikacijeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function handle(): void
    {
        $noveNekretnine = Nekretnine::with(['tip', 'slika', 'mesto', 'atributiVrednosti.nestoMoje.ucitajAtribut'])
            ->whereDate('created_at', today())
            ->get();
        if ($noveNekretnine->isEmpty()) {
            return;
        }

        $filteri = PretplatnikFilter::with([
            'pretplatnik',
            'tip',
            'vrednosti.definicija',
        ])
            ->whereNotNull('verified_at')
            ->get();
        foreach ($filteri as $filter) {
            $matchingNekretnine = $noveNekretnine
                ->filter(fn($nekretnina) => $nekretnina->id_tip_nekretnine === $filter->id_tipa)
                ->filter(fn($nekretnina) => $this->prolaziCenu($filter, $nekretnina))
                ->filter(fn($nekretnina) => $this->prolaziKvadraturu($filter, $nekretnina))
                ->filter(fn($nekretnina) => $this->prolaziDinamickeFiltere($filter, $nekretnina))
                ->values();
            if ($matchingNekretnine->isNotEmpty()) {
                PosaljiMejlJob::dispatch(
                    $matchingNekretnine->pluck('id')->all(),
                    $filter->id
                );
            }
        }
    }

    private function prolaziCenu(PretplatnikFilter $filter, Nekretnine $nekretnina): bool
    {
        $cenaZaPoredjenje = (int)$nekretnina->cena;

        if ($filter->cena_po_metru) {
            $kvadratura = (int)$nekretnina->atributiVrednosti
                ->firstWhere('naziv', 'Kvadratura')?->vrednost;

            if (! $kvadratura || $kvadratura <= 0) {
                return false;
            }

            $cenaZaPoredjenje = $nekretnina->cena / $kvadratura;
        }
        if ($filter->cena_min !== null && $cenaZaPoredjenje < $filter->cena_min) {
            return false;
        }

        if ($filter->cena_max !== null && $cenaZaPoredjenje > $filter->cena_max) {
            return false;
        }

        return true;
    }

    private function prolaziKvadraturu(PretplatnikFilter $filter, Nekretnine $nekretnina): bool
    {
        $kvadratura = (int)$nekretnina->atributiVrednosti
            ->firstWhere('naziv', 'Kvadratura')?->vrednost;
        if (! $kvadratura) {
            return $filter->kvadratura_min === null && $filter->kvadratura_max === null;
        }

        if ($filter->kvadratura_min !== null && $kvadratura < $filter->kvadratura_min) {
            return false;
        }

        if ($filter->kvadratura_max !== null && $kvadratura > $filter->kvadratura_max) {
            return false;
        }

        return true;
    }

    private function prolaziDinamickeFiltere(PretplatnikFilter $filter, Nekretnine $nekretnina): bool
    {
        foreach ($filter->vrednosti as $fv) {
            $definicija = $fv->definicija;
            $kljuc = $definicija->kljuc;

            switch ($definicija->tip) {
                case FilterDefinicija::TIP_RASPON:
                    $vrednostNek = $nekretnina->vrednostAtributa($definicija->naziv);

                    if (! $vrednostNek) {
                        return false;
                    }

                    if ($fv->vrednost_min !== null && $vrednostNek < $fv->vrednost_min) {
                        return false;
                    }

                    if ($fv->vrednost_max !== null && $vrednostNek > $fv->vrednost_max) {
                        return false;
                    }
                    break;

                case FilterDefinicija::TIP_KATEGORIJA:
                case FilterDefinicija::TIP_BOOLEAN:
                    $vrednostNek = $nekretnina->vrednostAtributa($definicija->naziv);

                    if (! $vrednostNek) {
                        return false;
                    }

                    if (mb_strtolower((string) $vrednostNek) !== mb_strtolower((string) $fv->vrednost)) {
                        return false;
                    }
                    break;
                case FilterDefinicija::TIP_VISE_IZBORA:
                    if ($kljuc === 'lokacija') {
                        $filtriranaMesta = $filter->vrednosti
                            ->where('filter_definicija_id', $fv->filter_definicija_id)
                            ->pluck('vrednost')
                            ->map(fn($v) => (int) $v);

                        if ($filtriranaMesta->isNotEmpty() && ! $filtriranaMesta->contains((int) $nekretnina->mesto_id)) {
                            return false;
                        }
                    }
                    break;
            }
        }

        return true;
    }
}
