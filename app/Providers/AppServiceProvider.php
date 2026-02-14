<?php

namespace App\Providers;

use App\Models\CollaborationImage;
use App\Models\CollaboratorMail;
use App\Observers\CollaborationImageObserver;
use App\Observers\CollaborationMailObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        CollaborationImage::observe(CollaborationImageObserver::class);
        CollaboratorMail::observe(CollaborationMailObserver::class);
    }
}
