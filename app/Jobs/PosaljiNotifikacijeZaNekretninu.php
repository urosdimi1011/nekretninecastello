<?php

namespace App\Jobs;

use App\Mail\NovaNekretnina;
use App\Models\FilterDefinicija;
use App\Models\Nekretnine;
use App\Models\PretplatnikFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PosaljiNotifikacijeZaNekretninu implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;

    public function __construct(public Nekretnine $nekretnina) {}

    public function handle(): void
    {
        $nekretnina = Nekretnine::with('a')->findOrFail($this->nekretnina->id);
        $filteri = PretplatnikFilter::where('id_tipa', $this->nekretnina->id_tipa)
            ->whereHas('pretplatnik', fn($q) => $q->whereNotNull('verified_at'))
            ->where(function ($q) {
                $q->whereNull('cena_min')
                    ->orWhere('cena_min', '<=', $this->nekretnina->cena);
            })
            ->where(function ($q) {
                $q->whereNull('cena_max')
                    ->orWhere('cena_max', '>=', $this->nekretnina->cena);
            })
            ->with(['pretplatnik', 'vrednosti.definicija'])
            ->get();


        $filteri = $filteri->filter(fn($filter) => $this->prolaziCenu($filter, $nekretnina))
            ->filter(fn($filter) => $this->prolaziKvadraturu($filter, $nekretnina))
            ->filter(fn($filter) => $this->prolaziDinamickeFiltere($filter, $nekretnina));

        foreach ($filteri as $filter) {
            PosaljiMejlJob::dispatch($this->nekretnina, $filter->pretplatnik)
                ->delay(now()->addSeconds(rand(1, 10)));
        }
    }


    private function prolaziCenu(PretplatnikFilter $filter, Nekretnine $nekretnina): bool
    {
        $cenaZaPoredjenje = $nekretnina->cena;

        if ($filter->cena_po_metru) {
            $kvadratura = $nekretnina->a
                ->firstWhere('atribut', 'Kvadratura')?->vrednost;

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
        $kvadratura = $nekretnina->a
            ->firstWhere('atribut', 'Kvadratura')?->vrednost;

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
                    $vrednostNek = $nekretnina->a
                        ->firstWhere('atribut', $definicija->naziv)?->vrednost;

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
                    $vrednostNek = $nekretnina->a
                        ->firstWhere('atribut', $definicija->naziv)?->vrednost;

                    if (! $vrednostNek) {
                        return false;
                    }

                    if (mb_strtolower($vrednostNek) !== mb_strtolower($fv->vrednost)) {
                        return false;
                    }
                    break;

                case FilterDefinicija::TIP_VISE_IZBORA:
                    if ($kljuc === 'lokacija') {
                        $filtriranaMesta = $filter->vrednosti
                            ->where('filter_definicija_id', $fv->filter_definicija_id)
                            ->pluck('vrednost')
                            ->map(fn($v) => (int) $v);

                        if ($filtriranaMesta->isNotEmpty() && ! $filtriranaMesta->contains($nekretnina->mesto_id)) {
                            return false;
                        }
                    }
                    break;
            }
        }

        return true;
    }
}
