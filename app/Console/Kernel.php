<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('notifikacije:posalji')
            ->dailyAt('17:00')
            ->timezone('Europe/Belgrade')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Notifikacije scheduler pao');
            });
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
