<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdvancedExerciseLocalB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_local:B';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "De même que précédemment, nous voulons compter toutes les annonces par départements";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads = DB::table('ads')
            ->where('is_draft', 0)
            ->get();
        echo "Total non-draft ads: " . $ads->count() . "\n";

        $adsByDepartment = DB::table('ads')
            ->join('users', 'ads.user_pp_id', '=', 'users.id')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->join('departments', 'cities.department_code', '=', 'departments.code')
            ->select('departments.name', DB::raw('count(ads.id) as total_ads'))
            ->where('ads.is_draft', 0)
            ->groupBy('departments.name')
            ->get();

        echo "\n" . "Total non-draft ads by department:\n";

        foreach ($adsByDepartment as $department) {
            echo $department->name . ": " . $department->total_ads . "\n";
        }
        $ads = DB::table('ads')
            ->where('is_draft', 1)
            ->get();
        echo "\n" . "Total draft ads: " . $ads->count() . "\n";

        $adsByDepartment = DB::table('ads')
            ->join('users', 'ads.user_pp_id', '=', 'users.id')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->join('departments', 'cities.department_code', '=', 'departments.code')
            ->select('departments.name', DB::raw('count(ads.id) as total_ads'))
            ->where('ads.is_draft', 1)
            ->groupBy('departments.name')
            ->get();

        echo "\n" . "Total draft ads by department:\n";

        foreach ($adsByDepartment as $department) {
            echo $department->name . ": " . $department->total_ads . "\n";
        }
    }

}