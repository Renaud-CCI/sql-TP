<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdvancedExerciseCreateProcedure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanced_exercise_create_procedure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "À partir des requêtes de l'exercice 10 - A, vous allez créer des procédures stockées permettant la création de toute une annonce et des objets liés à partir d'une liste de paramètres";

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try {
            // Exécuter le fichier SQL pour créer la procédure stockée
            DB::unprepared(file_get_contents('sql/procedures/create_ad.sql'));
            echo "Procédure stockée 'create_ad' ok.\n";
        } catch (\Exception $e) {
            echo "Erreur procédure stockée.\n" . $e->getMessage() . "\n";
            return;
        }


        $country = 'France';
        $zipCode = '42510';
        $name = 'Bresson';
        $firstName = 'Renaud';
        $email = 'renaud.bresson@email.com';
        $password = 'renaudrenaud';
        $isDraft = 0;
        $acceptShareContactInfos = 1;
        $title = "Recherche de foncier pour maraichage bio";
        $aboutContent = "de la terre et de l'eau serait un plus";
        $aboutProjectContent = "PAMPA Comestible";
        $isBio = 1;
        $experienceFarming = 'Bac STAE';
        $surfaceRangeMin = 5;
        $surfaceRangeMax = 20;
        $documentName = 'image.jpg';
        $documentPath = 'users/' . $documentName;
        $documentType = $this->getDocumentType($documentName);
        $documentSize = 9999999;
        $productionTypes = 'ProductionType1,ProductionType2';

        try {
            DB::beginTransaction();

            DB::statement("CALL create_ad(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $name,
                $firstName,
                $email,
                Hash::make($password),
                $country,
                $zipCode,
                $isDraft,
                $acceptShareContactInfos,
                $title,
                $aboutContent,
                $aboutProjectContent,
                $isBio,
                $experienceFarming,
                $surfaceRangeMin,
                $surfaceRangeMax,
                $documentName,
                $documentPath,
                $documentType,
                $documentSize,
                $productionTypes
            ]);

            DB::commit();
            echo "Annonce enregistrée avec succès.\n";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Erreur \n" . $e->getMessage() . "\n";
        }
    }

    private function getDocumentType($documentName)
    {
        $extension = pathinfo($documentName, PATHINFO_EXTENSION);
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'pdf':
                return 'application/pdf';
            case 'doc':
                return 'application/msword';
            case 'docx':
                return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            case 'xls':
                return 'application/vnd.ms-excel';
            case 'xlsx':
                return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            case 'txt':
                return 'text/plain';
            case 'html':
                return 'text/html';
            case 'mp3':
                return 'audio/mpeg';
            case 'wav':
                return 'audio/wav';
            case 'mp4':
                return 'video/mp4';
            case 'avi':
                return 'video/x-msvideo';
            case 'zip':
                return 'application/zip';
            case 'tar':
                return 'application/x-tar';
            default:
                return 'application/octet-stream';
        }
    }
}