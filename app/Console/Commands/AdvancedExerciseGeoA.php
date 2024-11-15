<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdvancedExerciseGeoA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_geo:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Pour une ville donnée, j'aimerais trier toutes les autres villes par ordre de distance";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Mettre l'id d'une ville donnée + distance
        $cityId = 1;
        $maxDistance = 20;

        $city = DB::table('cities')->where('id', $cityId)->first();

        if (!$city) {
            echo "City not found.\n";
            return;
        }

        // formule de distance de Haversine
        $cities = DB::table('cities')
            ->select('id', 'name', 'gps_lat', 'gps_lng', DB::raw("
                (6371 * acos(
                    cos(radians($city->gps_lat)) * 
                    cos(radians(gps_lat)) * 
                    cos(radians(gps_lng) - radians($city->gps_lng)) + 
                    sin(radians($city->gps_lat)) * 
                    sin(radians(gps_lat))
                )) AS distance
            "))
            ->where('id', '!=', $cityId)
            ->orderBy('distance')
            ->get();

        echo "Departure city: " . $city->name . "\n";

        foreach ($cities as $city) {
            if ($city->distance < $maxDistance) {
                echo "City: " . $city->name . " - Distance: " . round($city->distance, 2) . " km\n";
            }
        }
    }
}