<?php
namespace App\Modules\Billing\Services;
use App\Modules\Parking\Models\EntryExitRecord;
use App\Modules\Billing\Models\RatePlan;
use App\Modules\Billing\Models\FeeRecord;
use App\Modules\Billing\Strategies\RateCalculationStrategyInterface;
use App\Modules\Billing\Strategies\HourlyRateStrategy;
class FeeCalculationService
{
    public function calculateFee(EntryExitRecord $record): float
    {
        $parkingLot = $record->parkingLot;
        if (!$parkingLot) {
            throw new \Exception("Parking lot not found for entry record {$record->id}");
        }
        $ratePlan = RatePlan::where('parking_lot_id', $parkingLot->id)
                            ->where('is_active', true)
                            ->first();
        if (!$ratePlan) {
            throw new \Exception("No active rate plan found for parking lot ID: {$parkingLot->id}");
        }
        $strategy = match ($ratePlan->type) {
            'hourly' => app(HourlyRateStrategy::class),
            default => throw new \Exception("Unsupported rate plan type: {$ratePlan->type}"),
        };
        return $strategy->calculate($record);
    }
}
