<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdvancedExerciseTypeA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_type:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Récupérer toutes les annonces de type offre de foncier en utilisant la clause EXISTS. Une annonce dans la table 'ads' de type 'Offre de foncier' aura une entrée correspondante dans la table 'land_offer_ads'";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads = DB::table('ads')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('land_offer_ads')
                      ->whereColumn('land_offer_ads.ad_id', 'ads.id');
            })
            ->get();

        foreach ($ads as $ad) {
            echo "Ad ID: " . $ad->id . " - Title: " . $ad->title . "\n";
        }
    }

}