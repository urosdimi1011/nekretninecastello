<?php

namespace App\Jobs;

use App\Mail\NovaNekretnina;
use App\Models\Nekretnine;
use App\Models\PretplatnikFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PosaljiMejlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(
        public array $nekretninaIds,
        public int $filterId
    ) {}

    public function handle(): void
    {
        $filter = PretplatnikFilter::with(['pretplatnik', 'tip'])
            ->findOrFail($this->filterId);

        $nekretnine = Nekretnine::with([
            'tip',
            'slika',
            'mesto',
            'atributiVrednosti.nestoMoje.ucitajAtribut',
        ])
            ->whereIn('id', $this->nekretninaIds)
            ->get();

        if ($nekretnine->isEmpty()) {
            return;
        }

        Mail::to($filter->pretplatnik->email)
            ->send(new NovaNekretnina($nekretnine, $filter));
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Mejl nije poslat pretplatniku.', [
            'filter_id' => $this->filterId,
            'nekretnina_ids' => $this->nekretninaIds,
            'greska' => $exception->getMessage(),
        ]);
    }
}
