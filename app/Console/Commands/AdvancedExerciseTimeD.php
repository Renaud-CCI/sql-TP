<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvancedExerciseTimeD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_time:D';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Extraire tous les titres d'annonces avec la date de création dans un format français ( jour de la semaine, etc )";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads = DB::table('ads')
            ->select('title', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($ads as $ad) {
            $createdAt = Carbon::parse($ad->created_at)->locale('fr_FR');
            $formattedDate = $createdAt->isoFormat('dddd, D MMMM YYYY');

            echo "Title: " . $ad->title . " - Created At: " . $formattedDate . "\n";
        }
    }

}