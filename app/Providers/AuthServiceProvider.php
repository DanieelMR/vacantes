<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar si el usuario es administrador
        Gate::define('admin-only', function (Usuario $user) {
            return $user->isAdmin();
        });

        // Gate para verificar si el usuario puede editar
        Gate::define('can-edit', function (Usuario $user) {
            return $user->isAdmin() || $user->isEditor();
        });

        // Gate para gestión de usuarios
        Gate::define('manage-users', function (Usuario $user) {
            return $user->isAdmin();
        });
    }
}
