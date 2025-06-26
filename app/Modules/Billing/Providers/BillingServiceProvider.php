<?php
namespace App\Modules\Billing\Providers;
use Illuminate\Support\ServiceProvider;
use App\Modules\Billing\Services\FeeCalculationService;
use App\Modules\Billing\Strategies\HourlyRateStrategy;
use App\Modules\Billing\Strategies\RateCalculationStrategyInterface;
class BillingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FeeCalculationService::class, function ($app) {
            return new FeeCalculationService();
        });
        $this->app->bind(HourlyRateStrategy::class, function ($app) {
            return new HourlyRateStrategy();
        });
    }
    public function boot(): void
    {
        //
    }
}
