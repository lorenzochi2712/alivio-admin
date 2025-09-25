<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            \App\Console\Commands\MigrateFirebaseUsers::class,
        ]);
    }

    public function boot()
    {
        //
    }
}
