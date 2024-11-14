<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimpleExerciseC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple_exercise:C';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lister tous les types de productions qui ne sont associés à aucune annonce';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $productionGenres = DB::table('production_genres')            
            ->whereNull('production_genres.parent_id')
            ->select('production_genres.name')
            ->get();

        foreach ($productionGenres as $genre) {
            echo $genre->name . "\n";
        }
    }

}