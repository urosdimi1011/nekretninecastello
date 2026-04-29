<?php

namespace App\Console\Commands;

use App\Jobs\PosaljiNotifikacijeJob;
use Illuminate\Console\Command;

class PosaljiNotifikacije extends Command
{
    protected $signature   = 'notifikacije:posalji';
    protected $description = 'This send a mail with new real estate for subscriptions';

    public function handle(): int
    {
        PosaljiNotifikacijeJob::dispatch();

        $this->info('Notifikacije su dodate u queue.');

        return Command::SUCCESS;
    }
}
