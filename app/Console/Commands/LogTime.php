<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LogTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentTime = now()->toDateTimeString();
        Log::info("Current Time: " . $currentTime);

        // Tampilkan pesan ke console
        $this->info('Logged current time: ' . $currentTime);
    }
}
