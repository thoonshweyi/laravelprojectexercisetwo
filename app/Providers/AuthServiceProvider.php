<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Announcement;
use App\Policies\AnnouncementPol;
use App\Models\Attendance;
use App\Policies\AttendancePol;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Township;
use App\Models\Gender;
use App\Models\Religion;

use App\Policies\CommonPol;

use App\Models\Leave;
use App\Policies\LeavePol;
use App\Models\Post;
use App\Policies\PostsPol;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Announcement::class => AnnouncementPol::class,
        Attendance::class => AttendancePol::class,
        Country::class => CommonPol::class,
        Region::class => CommonPol::class,
        City::class => CommonPol::class,
        Township::class => CommonPol::class,
        Gender::class => CommonPol::class,
        Religion::class => CommonPol::class,


        Leave::class => LeavePol::class,
        Post::class => PostsPol::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
    }
}
