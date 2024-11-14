<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimpleExerciseF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple_exercise:F';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Afficher le premier document uploadé par chaque utilisateur';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
    //     $documents = DB::table('documents as d1')
    //         ->select('d1.user_id', 'd1.name', 'd1.created_at')
    //         ->whereRaw('d1.created_at = (select min(d2.created_at) from documents as d2 where d2.user_id = d1.user_id)')
    //         ->get();

    //     foreach ($documents as $document) {
    //         echo "User ID: " . $document->user_id . " - Document Name: " . $document->name . " - Uploaded At: " . $document->created_at . "\n";
    //     }
        $documents = DB::table('documents')
        ->select('user_id', 'name', 'created_at')
        ->whereIn('created_at', function($query) {
            $query->select(DB::raw('MIN(created_at)'))
            ->from('documents')
            ->groupBy('user_id');
        })
        ->get();
        
        foreach ($documents as $document) {
            echo "User ID: " . $document->user_id . " - Document Name: " . $document->name . " - Uploaded At: " . $document->created_at . "\n";
        }
    }

}