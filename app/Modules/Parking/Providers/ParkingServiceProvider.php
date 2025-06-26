<?php
namespace App\Modules\Parking\Providers;
use Illuminate\Support\ServiceProvider;
use App\Modules\Parking\Services\ParkingService;
use App\Modules\Parking\Repositories\ParkingRecordRepository;
use App\Modules\Parking\Repositories\Contracts\ParkingRecordRepositoryInterface;
class ParkingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ParkingRecordRepositoryInterface::class, ParkingRecordRepository::class);
        $this->app->singleton(ParkingService::class, function ($app) {
            return new ParkingService(
                $app->make(ParkingRecordRepositoryInterface::class)
            );
        });
    }
    public function boot(): void
    {
        //
    }
}
