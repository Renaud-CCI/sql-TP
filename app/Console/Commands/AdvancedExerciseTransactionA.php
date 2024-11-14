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

        try {

            // Enregistrement d'un utilisateur
            $countryId = DB::table('countries')->where('name_fr_fr', $country)->value('id');
            $zipCodeId = DB::table('cities')->where('zip_code', $zipCode)->value('id');

            if (!$countryId) {
                echo "Pays non trouvé.\n";
                die;
            } elseif (!$zipCodeId) {
                echo "Code postal non trouvé.\n";
                die;
            }

            // Créer un utilisateur
            //Préparation
            $insertUserQuery = "INSERT INTO users (name, first_name, email, password, country_id, zip_code_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Execution
            DB::insert($insertUserQuery, [
                $name,
                $firstName,
                $email,
                Hash::make($password),
                $countryId,
                $zipCodeId,
                Carbon::now(),
                Carbon::now(),
            ]);

            // Récupération Id
            $userId = DB::getPdo()->lastInsertId();

            // Enregistrement de l'annonce
            // Préaparation
            $insertAdQuery = "INSERT INTO ads (user_admin_id, user_pp_id, is_draft, accept_share_contact_infos, title, about_content, about_project_content, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Execution
            DB::insert($insertAdQuery, [
                $userId,
                $userId,
                $isDraft,
                $acceptShareContactInfos,
                $title,
                $aboutContent,
                $aboutProjectContent,
                Carbon::now(),
                Carbon::now(),
            ]);

            // Récupération Id
            $adId = DB::getPdo()->lastInsertId();

            // Enregistrement des détails de l'annonce
            $insertLandSeekAdQuery = "INSERT INTO land_seek_ads (ad_id, is_bio, experience_farming, surface_range_min, surface_range_max, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            DB::insert($insertLandSeekAdQuery, [
                $adId,
                $isBio,
                $experienceFarming,
                $surfaceRangeMin,
                $surfaceRangeMax,
                Carbon::now(),
                Carbon::now(),
            ]);

            // Enregistrement du document
            $insertDocumentQuery = "INSERT INTO documents (name, path, type, size, user_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            DB::insert($insertDocumentQuery, [
                $documentName,
                $documentPath,
                $documentType,
                $documentSize,
                $userId,
                Carbon::now(),
                Carbon::now(),
            ]);

            // Récupérer l'ID du document inséré
            $documentId = DB::getPdo()->lastInsertId();

            // Enregistrement dans la table documentables
            $insertDocumentableQuery = "INSERT INTO documentables (document_id, documentable_id, documentable_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
            DB::insert($insertDocumentableQuery, [
                $documentId,
                $adId,
                'ads',
                Carbon::now(),
                Carbon::now(),
            ]);


            DB::commit();
            echo "Annonce de recherche de foncier insérée avec succès.\n";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Erreur lors de l'insertion de l'annonce de recherche de foncier.\n" . $e->getMessage() . "\n";
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