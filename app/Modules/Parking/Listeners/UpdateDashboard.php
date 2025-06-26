<?php
namespace App\Modules\Parking\Listeners;
use App\Modules\Parking\Events\VehicleEntered;
use App\Modules\Parking\Events\VehicleExited;
use App\Modules\Parking\Models\ParkingSpace;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
class UpdateDashboard implements ShouldQueue
{
    public function handle(object $event): void
    {
        $lotId = $event->record->parking_lot_id;
        $parkingSpace = $event->record->parkingSpace;
        if ($event instanceof VehicleEntered) {
            Log::info("A vehicle entered parking lot #{$lotId}. Updating dashboard and cache.");
            Cache::forget("parking_lot_{$lotId}_available_spaces");
        } elseif ($event instanceof VehicleExited) {
            Log::info("A vehicle exited parking lot #{$lotId}. Updating dashboard and cache.");
            if ($parkingSpace && $parkingSpace->status !== 'available') {
                $parkingSpace->update(['status' => 'available']);
            }
            Cache::forget("parking_lot_{$lotId}_available_spaces");
        }
    }
}
