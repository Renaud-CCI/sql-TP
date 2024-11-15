<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateProcedureCreateAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:procedure_create_ad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create stored procedure create_ad';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try {
            // Vérifier si la procédure existe déjà
            $exists = DB::select("SELECT ROUTINE_NAME FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_NAME = 'create_ad'");

            if (empty($exists)) {
                // Exécuter le fichier SQL pour créer la procédure stockée
                DB::unprepared(file_get_contents('sql/procedures/create_ad.sql'));
                echo "Procédure stockée 'create_ad' créée avec succès.\n";
            } else {
                echo "Procédure stockée 'create_ad' existe déjà.\n";
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la création de la procédure stockée.\n" . $e->getMessage() . "\n";
        }
    }
}