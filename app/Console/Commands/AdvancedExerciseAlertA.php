<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdvancedExerciseAlertA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_alert:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Trouver les demandeurs qui sont dans la même région que des offreurs et proposent des types de production identique";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $results = DB::table('land_seek_ads as seekers')
            ->join('ads as seeker_ads', 'seekers.ad_id', '=', 'seeker_ads.id')
            ->join('users as seeker_users', 'seeker_ads.user_pp_id', '=', 'seeker_users.id')
            ->join('cities as seeker_cities', 'seeker_users.zip_code_id', '=', 'seeker_cities.id')
            ->join('departments as seeker_departments', 'seeker_cities.department_code', '=', 'seeker_departments.code')
            ->join('regions as seeker_regions', 'seeker_departments.region_code', '=', 'seeker_regions.code')
            ->join('productionable_genres as seeker_genres', function($join) {
                $join->on('seekers.id', '=', 'seeker_genres.productionable_genre_id')
                     ->where('seeker_genres.productionable_genre_type', '=', 'land_seek_ads');
            })
            ->join('production_genres as seeker_productions', 'seeker_genres.production_genre_id', '=', 'seeker_productions.id')
            ->join('productionable_genres as offerer_genres', function($join) {
                $join->on('seeker_productions.id', '=', 'offerer_genres.production_genre_id')
                     ->where('offerer_genres.productionable_genre_type', '=', 'land_offer_ads');
            })
            ->join('land_offer_ads as offerers', 'offerer_genres.productionable_genre_id', '=', 'offerers.id')
            ->join('ads as offerer_ads', 'offerers.ad_id', '=', 'offerer_ads.id')
            ->join('users as offerer_users', 'offerer_ads.user_pp_id', '=', 'offerer_users.id')
            ->join('cities as offerer_cities', 'offerer_users.zip_code_id', '=', 'offerer_cities.id')
            ->join('departments as offerer_departments', 'offerer_cities.department_code', '=', 'offerer_departments.code')
            ->join('regions as offerer_regions', 'offerer_departments.region_code', '=', 'offerer_regions.code')
            ->whereColumn('seeker_regions.code', 'offerer_regions.code')
            ->select('seeker_users.name as seeker_name', 'offerer_users.name as offerer_name', 'seeker_regions.name as region_name', 'seeker_productions.name as production_name')
            ->distinct()
            ->get();

        foreach ($results as $result) {
            echo "Seeker: " . $result->seeker_name . " - Offerer: " . $result->offerer_name . " - Region: " . $result->region_name . " - Production: " . $result->production_name . "\n";
        }
    }
}