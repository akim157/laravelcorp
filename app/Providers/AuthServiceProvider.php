<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Corp\Model' => 'Corp\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('VIEW_ADMIN', function($user){
//            return $user->id == $post->user_id;
            return $user->canDo('VIEW_ADMIN'); //canDo - возвращает true если у пользователя есть соотвествующие право
        });
        //
        Gate::define('VIEW_ADMIN_ARTICLES', function($user){
            return $user->canDo('VIEW_ADMIN_ARTICLES'); 
        });
    }
}
