<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the app as a fresh install';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->call('db:wipe', array_filter([
            '--force' => true,
        ]));

        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/migration.sql'));
        echo "migration ok\n";

        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/seeds/countries.sql'));
        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/seeds/regions.sql'));
        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/seeds/departments.sql'));
        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/seeds/cities.sql'));

        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/seeds/app.sql'));
        app('db')->unprepared(file_get_contents(app()->basePath().'/sql/seeds/generated.sql'));
        echo "seeds ok\n";
    }
}