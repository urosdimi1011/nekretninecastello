<?php

namespace App\Jobs;

use App\Mail\NovaNekretnina;
use App\Models\Nekretnine;
use App\Models\Pretplatnik;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PosaljiMejlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 30;

    public function __construct(
        public Nekretnine  $nekretnina,
        public Pretplatnik $pretplatnik
    ) {}

    public function handle(): void
    {
        Mail::to($this->pretplatnik->email)
            ->send(new NovaNekretnina($this->nekretnina, $this->pretplatnik));
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error("Mejl nije poslat pretplatniku {$this->pretplatnik->email}", [
            'nekretnina_id' => $this->nekretnina->id,
            'greska'        => $exception->getMessage(),
        ]);
    }
}
