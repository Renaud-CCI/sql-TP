<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateAdsSeekAdsView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:ads_seek_ads_view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create ads-land_seek_ads view';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try {
            $exists = DB::select("SELECT TABLE_NAME FROM information_schema.VIEWS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ads_land_seek_ads_view'");

            if (empty($exists)) {
                DB::unprepared(file_get_contents('sql/views/ads_land_seek_ads_view.sql'));
                echo "Vue 'ads_land_seek_ads_view' créée avec succès.\n";
            } else {
                echo "Vue 'ads_land_seek_ads_view' existe déjà.\n";
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la création de la vue.\n" . $e->getMessage() . "\n";
        }
    }
}