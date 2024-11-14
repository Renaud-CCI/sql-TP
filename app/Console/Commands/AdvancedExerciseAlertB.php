<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdvancedExerciseAlertB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_alert:B';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Trouver les demandeurs qui sont dans le même département que des offreurs, et qui demande une surface min/max correspondante à une surface proposée par un offreur";

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
            ->join('users as offerer_users', 'offerer_users.zip_code_id', '=', 'seeker_cities.id')
            ->join('ads as offerer_ads', 'offerer_users.id', '=', 'offerer_ads.user_pp_id')
            ->join('land_offer_ads as offerers', function($join) {
                $join->on('offerer_ads.id', '=', 'offerers.ad_id')
                     ->whereColumn('seekers.surface_range_min', '<=', 'offerers.surface')
                     ->whereColumn('seekers.surface_range_max', '>=', 'offerers.surface');
            })
            ->select('seeker_users.name as seeker_name', 'offerer_users.name as offerer_name', 'seeker_departments.name as department_name', 'seekers.surface_range_min', 'seekers.surface_range_max', 'offerers.surface')
            ->distinct()
            ->get();

        foreach ($results as $result) {
            echo "Seeker: " . $result->seeker_name . " - Offerer: " . $result->offerer_name . " - Department: " . $result->department_name . " - Seeker Surface Range: " . $result->surface_range_min . "-" . $result->surface_range_max . " - Offerer Surface: " . $result->surface . "\n";
        }
    }
}