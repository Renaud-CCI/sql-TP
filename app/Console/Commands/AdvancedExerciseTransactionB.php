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
                    DB::table('land_seek_ads')->where('ad_id', $adId)->delete();
                    // Supprimer l'annonce
                    DB::table('ads')->where('id', $adId)->delete();

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