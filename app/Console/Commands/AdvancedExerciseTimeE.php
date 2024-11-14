<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvancedExerciseTimeE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_time:E';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Extraire tous les titres d'annonces avec le nombre de jours écoulés depuis leur création";

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
            $createdAt = Carbon::parse($ad->created_at);
            $daysElapsed = $createdAt->diffInDays(Carbon::now());

            echo "Title: " . $ad->title . " - Days Elapsed: " . $daysElapsed . "\n";
        }
    }

}