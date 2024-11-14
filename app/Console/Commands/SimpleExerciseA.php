<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimpleExerciseA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple_exercise:A';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lister tous les utilisateurs dont le code postal commence par 6 ou 0';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $users = DB::table('users')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->where('cities.zip_code', 'like', '6%')
            ->orWhere('cities.zip_code', 'like', '0%')
            ->select('users.name', 'cities.zip_code as zip_code')
            ->get();

        foreach ($users as $user) {
            echo $user->name . " - " . $user->zip_code . "\n";
        }
    }
}