<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvancedExerciseTimeB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_time:B';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Trouver toutes les annonces créées entre la date du 05/09/2019 et aujourd'hui";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $startDate = Carbon::create(2019, 9, 5);
        $endDate = Carbon::now();

        $ads = DB::table('ads')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($ads as $ad) {
            echo "Ad ID: " . $ad->id . " - Created At: " . $ad->created_at . "\n";
        }        
    }

}