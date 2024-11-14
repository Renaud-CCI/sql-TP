<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvancedExerciseTimeA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_time:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Trouver tous les utilisateurs qui se sont connectés les 48 derniers mois, triés de la plus récente connexion à la plus ancienne (updated_at est la colonne qui contient la dernière date de connexion)";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $monthsDelay = 48;
        $users = DB::table('users')
            ->where('updated_at', '>=', Carbon::now()->subMonths($monthsDelay))
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($users as $user) {
            echo "User ID: " . $user->id . " - Last Login: " . $user->updated_at . "\n";
        }
    }

}