<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SoftDeletesMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::macro('softDeletes', function ($prefix, $controller) {
            Route::prefix($prefix)->group(function () use ($controller, $prefix) {
                Route::get('trashed', [$controller, 'trashed'])->name("$prefix.trashed");
                Route::patch('{user}/restore', [$controller, 'restore'])->name("$prefix.restore");
                Route::delete('{user}/delete', [$controller, 'delete'])->name("$prefix.delete");
            });
        });
    }
}
