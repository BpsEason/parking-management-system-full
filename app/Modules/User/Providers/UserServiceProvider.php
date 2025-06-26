<?php
namespace App\Modules\User\Providers;
use Illuminate\Support\ServiceProvider;
use App\Modules\User\Services\UserService;
use App\Modules\User\Policies\UserPolicy;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
    }
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }
}
