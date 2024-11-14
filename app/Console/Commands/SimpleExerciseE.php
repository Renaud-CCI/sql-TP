<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimpleExerciseE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple_exercise:E';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lister le nombre de documents uploadés par chaque utilisateur qui sont de type image';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $imageDocuments = DB::table('documents')
            ->select('user_id', DB::raw('count(*) as total'))
            ->where('type', 'like', 'image/%')
            ->groupBy('user_id')
            ->get();

        foreach ($imageDocuments as $document) {
            echo "userID: " . $document->user_id . " - total images: " . $document->total . "\n";
        }
    }

}