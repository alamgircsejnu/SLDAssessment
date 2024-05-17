<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserSaved::class => [
            SaveUserBackgroundInformation::class,
        ],
    ];


    public function boot()
    {
        parent::boot();
    }
}
