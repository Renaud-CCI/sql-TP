<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AppInstall;
use App\Console\Commands\SimpleExerciseA;
use App\Console\Commands\SimpleExerciseB;
use App\Console\Commands\SimpleExerciseC;
use App\Console\Commands\SimpleExerciseD;
use App\Console\Commands\SimpleExerciseE;
use App\Console\Commands\SimpleExerciseF;
use App\Console\Commands\AdvancedExerciseLocalA;
use App\Console\Commands\AdvancedExerciseLocalB;
use App\Console\Commands\AdvancedExerciseLocalC;
use App\Console\Commands\AdvancedExerciseTypeA;
use App\Console\Commands\AdvancedExerciseTypeB;
use App\Console\Commands\AdvancedExerciseAlertA;
use App\Console\Commands\AdvancedExerciseAlertB;
use App\Console\Commands\AdvancedExerciseGeoA;
use App\Console\Commands\AdvancedExerciseTransactionA;
use App\Console\Commands\AdvancedExerciseTransactionB;
use App\Console\Commands\AdvancedExerciseTimeA;
use App\Console\Commands\AdvancedExerciseTimeB;
use App\Console\Commands\AdvancedExerciseTimeC;
use App\Console\Commands\AdvancedExerciseTimeD;
use App\Console\Commands\AdvancedExerciseTimeE;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AppInstall::class,
        SimpleExerciseA::class,
        SimpleExerciseB::class,
        SimpleExerciseC::class,
        SimpleExerciseD::class,
        SimpleExerciseE::class,
        SimpleExerciseF::class,
        AdvancedExerciseLocalA::class,
        AdvancedExerciseLocalB::class,
        AdvancedExerciseLocalC::class,
        AdvancedExerciseTypeA::class,
        AdvancedExerciseTypeB::class,
        AdvancedExerciseAlertA::class,
        AdvancedExerciseAlertB::class,
        AdvancedExerciseGeoA::class,
        AdvancedExerciseTransactionA::class,
        AdvancedExerciseTransactionB::class,
        AdvancedExerciseTimeA::class,
        AdvancedExerciseTimeB::class,
        AdvancedExerciseTimeC::class,
        AdvancedExerciseTimeD::class,
        AdvancedExerciseTimeE::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
