<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PosaljiNotifikacije extends Command
{
    protected $signature   = 'notifikacije:posalji';
    protected $description = 'It send a mail with new real estate for subscriptions';

    public function handle()
    {
        return Command::SUCCESS;
    }
}
