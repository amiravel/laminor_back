<?php

namespace Modules\Users\App\Providers;

use Illuminate\Support\Facades\Route;
use \Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        $this->mapApiRoutes();
    }

    public function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->name('users.api.client.')
            ->prefix('/api/users/client/')
            ->group(__DIR__ . '/../../routes/client.php');

        Route::middleware('api')
            ->name('users.api.admin.')
            ->prefix('/api/users/admin/')
            ->group(__DIR__ . '/../../routes/admin.php');

        Route::middleware('api')
            ->name('users.api.general.')
            ->prefix('/api/users/')
            ->group(__DIR__ . '/../../routes/general.php');
    }
}
