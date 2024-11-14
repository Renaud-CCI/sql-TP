<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SimpleExerciseB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simple_exercise:B';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lister tous les utilisateurs et leur département correspondant';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $users = DB::table('users')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->join('departments', 'cities.department_code', '=', 'departments.code')
            ->select('users.name', 'departments.name as department_name')
            ->get();

        foreach ($users as $user) {
            echo $user->name . " - " . $user->department_name . "\n";
        }
    }

}