<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Krs;

class RemoveDuplicateKrs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-duplicate-krs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all records with idperiode 20181
        $krsRecords = Krs::where('idperiode', '!=', '20232')->get();

        // Group records by 'idperiode', 'namakelas', 'nim', and 'idmk'
        $groupedRecords = $krsRecords->groupBy(function ($item, $key) {
            return $item['idperiode'] . '-' . $item['namakelas'] . '-' . $item['nim'] . '-' . $item['idmk'] . '-' . $item['nhuruf'];
        });

        $deletedCount = 0;

        foreach ($groupedRecords as $groupKey => $records) {
            if ($records->count() > 1) {
                // Get the first record (to keep) and the rest (to delete)
                $firstRecord = $records->shift();

                foreach ($records as $duplicate) {
                    $duplicate->delete();
                    $deletedCount++;
                }
            }
        }

        $this->info("Removed $deletedCount duplicate records from KRS table with idperiode 20181.");
    }
}
