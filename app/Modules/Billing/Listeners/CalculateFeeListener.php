<?php
namespace App\Modules\Billing\Listeners;
use App\Modules\Parking\Events\VehicleExited;
use App\Modules\Billing\Services\FeeCalculationService;
use App\Modules\Billing\Models\FeeRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
class CalculateFeeListener implements ShouldQueue
{
    protected FeeCalculationService $feeCalculationService;
    public function __construct(FeeCalculationService $feeCalculationService)
    {
        $this->feeCalculationService = $feeCalculationService;
    }
    public function handle(VehicleExited $event): void
    {
        try {
            $record = $event->record;
            Log::info("Calculating fee for record ID: {$record->id}");
            $fee = $this->feeCalculationService->calculateFee($record);
            FeeRecord::create([
                'entry_exit_record_id' => $record->id,
                'amount' => $fee,
                'paid_amount' => null,
                'payment_method' => 'pending',
                'paid_at' => null,
            ]);
            $record->update(['total_fee' => $fee, 'is_paid' => false]);
            Log::info("Fee calculated for record ID: {$record->id}, amount: {$fee}. Fee record created.");
        } catch (\Exception $e) {
            Log::error("Failed to calculate fee for record ID: {$event->record->id}. Error: " . $e->getMessage());
        }
    }
}
