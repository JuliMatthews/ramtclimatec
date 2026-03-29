<?php

namespace App\Providers;

use App\Models\OrdenTrabajo;
use App\Observers\OrdenTrabajoObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        OrdenTrabajo::observe(OrdenTrabajoObserver::class);
    }
}