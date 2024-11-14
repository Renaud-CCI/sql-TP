<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdvancedExerciseLocalA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_local:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Pour faire fonctionner la recherche par carte interactive, il faut pouvoir récupérer le nombre d'annonces par région qui ne sont pas en statut brouillon (is_draft=0). Récupérer également le nom de la région";

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

        $adsByRegion = DB::table('ads')
            ->join('users', 'ads.user_pp_id', '=', 'users.id')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->join('departments', 'cities.department_code', '=', 'departments.code')
            ->join('regions', 'departments.region_code', '=', 'regions.code')
            ->select('regions.name', DB::raw('count(ads.id) as total_ads'))
            ->where('ads.is_draft', 0)
            ->groupBy('regions.name')
            ->get();

        echo "\n" . "Total non-draft ads by region:\n";

        foreach ($adsByRegion as $region) {
            echo $region->name . ": " . $region->total_ads . "\n";
        }
        $ads = DB::table('ads')
            ->where('is_draft', 1)
            ->get();
        echo "\n" . "Total draft ads: " . $ads->count() . "\n";

        $adsByRegion = DB::table('ads')
            ->join('users', 'ads.user_pp_id', '=', 'users.id')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->join('departments', 'cities.department_code', '=', 'departments.code')
            ->join('regions', 'departments.region_code', '=', 'regions.code')
            ->select('regions.name', DB::raw('count(ads.id) as total_ads'))
            ->where('ads.is_draft', 1)
            ->groupBy('regions.name')
            ->get();

        echo "\n" . "Total draft ads by region:\n";

        foreach ($adsByRegion as $region) {
            echo $region->name . ": " . $region->total_ads . "\n";
        }

        $allRegionsWithAds = DB::table('ads')
        ->join('users', 'ads.user_pp_id', '=', 'users.id')
        ->join('cities', 'users.zip_code_id', '=', 'cities.id')
        ->join('departments', 'cities.department_code', '=', 'departments.code')
        ->join('regions', 'departments.region_code', '=', 'regions.code')
        ->select('regions.name', DB::raw('count(ads.id) as total_ads'))
        ->groupBy('regions.name')
        ->get();

        echo "\n" . "Total regions with ads:\n";

        foreach ($allRegionsWithAds as $region) {
            echo $region->name . "\n";
        }
    }

}