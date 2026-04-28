<?php

namespace App\Jobs;

use App\Models\Nekretnine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PosaljiNotifikacijeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 120;

    public function __construct() {}
    public function handle(): void
    {
        $noveNekretnine = Nekretnine::whereDate('created_at', today())
            ->with(['tip', 'slika', 'mesto'])
            ->get();

        if ($noveNekretnine->isEmpty()) return;

        $noveNekretnine->each(function ($nekretnina) {
            PosaljiNotifikacijeZaNekretninu::dispatch($nekretnina);
        });
    }
}
