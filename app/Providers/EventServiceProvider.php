<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Modules\Parking\Events\VehicleEntered;
use App\Modules\Parking\Events\VehicleExited;
use App\Modules\Parking\Listeners\UpdateDashboard;
use App\Modules\Billing\Listeners\CalculateFeeListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // --- Parking Module Events ---
        VehicleEntered::class => [
            UpdateDashboard::class,
        ],
        VehicleExited::class => [
            UpdateDashboard::class,
            CalculateFeeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
