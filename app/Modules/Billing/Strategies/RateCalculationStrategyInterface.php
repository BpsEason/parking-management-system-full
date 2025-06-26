<?php
namespace App\Modules\Billing\Strategies;
use App\Modules\Parking\Models\EntryExitRecord;
interface RateCalculationStrategyInterface
{
    public function calculate(EntryExitRecord $record): float;
}
