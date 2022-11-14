<?php

namespace App\Providers;

use App\Community;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();
        $this->app['auth']->viaRequest('api', function ($request) {
            return app('auth')->setRequest($request)->user();
        });
        Gate::define('community', function (User $user) {
            return $user->role === 'community';
        });

        Gate::define('verified', function (User $user) {
            $community = Community::firstWhere('user_id',$user->id);
            // dd($user->role === 'community' && $verified->is_verified == true);
            return $user->role === 'community' && $community->is_verified == true;
        });
        //
        Gate::define('user', function (User $user) {
            return $user->role === 'user';
        });
    }
}
