<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdvancedExerciseTransactionB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_transaction:B';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Supprimer l'annonce que vous avez créé. Les entités enfants ont-elles été bien supprimées ? A-t-on besoin d'une transaction ?";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $userId = DB::table('users')->where('email', 'renaud.bresson@email.com')->value('id');

            if ($userId) {
                // Id de la dernière annonce du user
                $adId = DB::table('ads')
                    ->where('user_pp_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->value('id');

                if ($adId) {
                    // Supprimer les entités enfants
                    DB::statement("PREPARE stmt1 FROM 'DELETE FROM land_seek_ads WHERE ad_id = ?'");
                    DB::statement("SET @adId = ?", [$adId]);
                    DB::statement("EXECUTE stmt1 USING @adId");
                    DB::statement("DEALLOCATE PREPARE stmt1");

                    // Supprimer les documents associés
                    $documentIds = DB::table('documentables')
                        ->where('documentable_id', $adId)
                        ->where('documentable_type', 'ads')
                        ->pluck('document_id');

                    DB::statement("PREPARE stmt2 FROM 'DELETE FROM documents WHERE id = ?'");
                    foreach ($documentIds as $documentId) {
                        DB::statement("SET @documentId = ?", [$documentId]);
                        DB::statement("EXECUTE stmt2 USING @documentId");
                    }
                    DB::statement("DEALLOCATE PREPARE stmt2");

                    DB::statement("PREPARE stmt3 FROM 'DELETE FROM documentables WHERE documentable_id = ? AND documentable_type = ?'");
                    DB::statement("SET @adId = ?, @documentableType = 'ads'", [$adId]);
                    DB::statement("EXECUTE stmt3 USING @adId, @documentableType");
                    DB::statement("DEALLOCATE PREPARE stmt3");

                    // Supprimer l'annonce
                    DB::statement("PREPARE stmt4 FROM 'DELETE FROM ads WHERE id = ?'");
                    DB::statement("SET @adId = ?", [$adId]);
                    DB::statement("EXECUTE stmt4 USING @adId");
                    DB::statement("DEALLOCATE PREPARE stmt4");
                    
                    DB::commit();
                    echo "Annonce et entités enfants supprimées.\n";
                } else {
                    echo "Annonce non trouvée.\n";
                }
            } else {
                echo "Utilisateur non trouvé.\n";
            }
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Erreur \n";
        }
    }
}