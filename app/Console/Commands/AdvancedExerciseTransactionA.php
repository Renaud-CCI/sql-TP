<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdvancedExerciseTransactionA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_transaction:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Insérez une annonce de recherche de foncier, avec les données de votre choix mais en remplissant 100% de tout ce qui est disponible, dans une transaction qui garantit l'intégrité des données de bout en bout";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            // Enregistrement d'un utilisateur
            $countryId = DB::table('countries')->where('name_fr_fr', 'France')->value('id');
            $zipCodeId = DB::table('cities')->where('zip_code', '42510')->value('id');
            
            $userId = DB::table('users')->insertGetId([
                'name' => 'Bresson',
                'first_name' => 'Renaud',
                'email' => 'renaud.bresson@email.com',
                'password' => Hash::make('renaudrenaud'),
                'country_id' => $countryId,
                'zip_code_id' => $zipCodeId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Energistrement de l'annonce
            $adId = DB::table('ads')->insertGetId([
                'user_admin_id' => $userId,
                'user_pp_id' => $userId,
                'is_draft' => 0,
                'accept_share_contact_infos' => 1,
                'title' => "Recherche de foncier pour maraichage bio",
                'about_content' => "de la terre et de l'eau serait un plus",
                'about_project_content' => "PAMPA Comestible",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Enregistrement des détails de l'annonce
            DB::table('land_seek_ads')->insert([
                'ad_id' => $adId,
                'is_bio' => 1,
                'experience_farming' => 'Bac STAE',
                'surface_range_min' => 5,
                'surface_range_max' => 20,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::commit();
            echo "Annonce de recherche de foncier insérée avec succès.\n";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Erreur lors de l'insertion de l'annonce de recherche de foncier.\n";
        }
    }
}