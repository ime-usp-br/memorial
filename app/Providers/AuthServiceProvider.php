<?php

namespace App\Providers;

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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('administrador', function ($user) {
            if ($user->role == 'administrador' || env('SENHAUNICA_ADMINS') == $user->codpes) {
                return true;
            }
        });


        Gate::define('curador', function ($user, $homenageado_id){
            if($user->role == 'curador' && $user->souCuradorHomenageado($homenageado_id)){
                return true;
            }
        });
    }
}
