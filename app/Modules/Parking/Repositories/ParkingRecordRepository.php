<?php
namespace App\Modules\Parking\Repositories;
use App\Modules\Parking\Models\EntryExitRecord;
use App\Modules\Parking\Models\Vehicle;
use App\Modules\Parking\Models\ParkingSpace;
use App\Modules\Parking\Repositories\Contracts\ParkingRecordRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
class ParkingRecordRepository implements ParkingRecordRepositoryInterface
{
    public function createEntryRecord(Vehicle $vehicle, ParkingSpace $space): EntryExitRecord
    {
        return EntryExitRecord::create([
            'parking_lot_id' => $space->parking_lot_id,
            'vehicle_id' => $vehicle->id,
            'parking_space_id' => $space->id,
            'entry_time' => now(),
            'is_paid' => $vehicle->user_id ? true : false,
        ]);
    }
    public function findUnpaidRecordByLicensePlate(string $licensePlate): ?EntryExitRecord
    {
        return EntryExitRecord::whereHas('vehicle', function ($query) use ($licensePlate) {
            $query->where('license_plate_number', $licensePlate);
        })->whereNull('exit_time')
          ->where('is_paid', false)
          ->first();
    }
    public function updateExitRecord(EntryExitRecord $record): bool
    {
        $record->exit_time = now();
        $record->is_paid = false;
        return $record->save();
    }
    public function findById(int $id): ?EntryExitRecord
    {
        return EntryExitRecord::find($id);
    }
    public function getOccupiedSpacesByLot(int $lotId): Collection
    {
        return ParkingSpace::where('parking_lot_id', $lotId)
                            ->where('status', 'occupied')
                            ->get();
    }
}
