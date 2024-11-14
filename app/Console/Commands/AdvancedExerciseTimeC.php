<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvancedExerciseTimeC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_time:C';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Extraire tous les titres d'annonces avec en colonne séparées l'année de création et le mois";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads = DB::table('ads')
            ->select('title', DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($ads as $ad) {
            echo "Title: " . $ad->title . " - Year: " . $ad->year . " - Month: " . $ad->month . "\n";
        }
    }

}