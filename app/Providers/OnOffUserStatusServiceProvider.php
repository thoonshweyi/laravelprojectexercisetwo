<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

class OnOffUserStatusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // View::composer('*',function($view){
        //     $onlineusers = User::Onlineusers();
        //     $offlineusers = User::Offineusers();

        //      $view->with("onlineusers",$onlineusers);
        //     // $view->with([
        //     //     "onlineusers"=>$onlineusers,
        //     //     "offlineusers"=>$offlineusers
        //     // ]);

        // });

        view()->composer('*',function($view){
            $onlineusers = User::Onlineusers();

            $view->with("onlineusers",$onlineusers);

        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
