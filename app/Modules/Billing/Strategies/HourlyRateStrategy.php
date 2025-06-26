<?php
namespace App\Modules\Billing\Strategies;
use App\Modules\Parking\Models\EntryExitRecord;
class HourlyRateStrategy implements RateCalculationStrategyInterface
{
    public function calculate(EntryExitRecord $record): float
    {
        if (!$record->exit_time) {
            throw new \InvalidArgumentException("EntryExitRecord must have an exit_time for hourly calculation.");
        }
        $ratePlan = $record->parkingLot->ratePlans()->where('type', 'hourly')->where('is_active', true)->first();
        if (!$ratePlan || !isset($ratePlan->rules['hourly_rate'])) {
            return $record->entry_time->diffInHours($record->exit_time) * 40; 
        }
        $durationInHours = $record->exit_time->diffInHours($record->entry_time);
        $hourlyRate = $ratePlan->rules['hourly_rate'];
        $maxDailyFee = $ratePlan->rules['max_daily_fee'] ?? null;
        $totalFee = $durationInHours * $hourlyRate;
        if ($maxDailyFee !== null && $totalFee > $maxDailyFee) {
            $totalFee = $maxDailyFee;
        }
        return $totalFee;
    }
}
