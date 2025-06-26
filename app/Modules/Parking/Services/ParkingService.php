<?php
namespace App\Modules\Parking\Services;
use App\Modules\Parking\Models\Vehicle;
use App\Modules\Parking\Models\ParkingSpace;
use App\Modules\Parking\Models\EntryExitRecord;
use App\Modules\Parking\Events\VehicleEntered;
use App\Modules\Parking\Events\VehicleExited;
use App\Modules\Parking\Repositories\Contracts\ParkingRecordRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NoAvailableSpaceException;
use App\Exceptions\RecordNotFoundException;
class ParkingService
{
    protected ParkingRecordRepositoryInterface $parkingRecordRepository;
    public function __construct(ParkingRecordRepositoryInterface $parkingRecordRepository)
    {
        $this->parkingRecordRepository = $parkingRecordRepository;
    }
    /**
     * 處理車輛入場邏輯。
     * @throws NoAvailableSpaceException 如果找不到可用車位
     */
    public function recordVehicleEntry(string $licensePlate, int $parkingLotId): EntryExitRecord
    {
        return DB::transaction(function () use ($licensePlate, $parkingLotId) {
            $vehicle = Vehicle::firstOrCreate(['license_plate_number' => $licensePlate, 'parking_lot_id' => $parkingLotId]);
            $availableSpace = ParkingSpace::where('parking_lot_id', $parkingLotId)
                                          ->where('status', 'available')
                                          ->lockForUpdate()
                                          ->first();
            if (!$availableSpace) {
                throw new NoAvailableSpaceException("No available spaces found in parking lot ID: {$parkingLotId}");
            }
            $availableSpace->update(['status' => 'occupied']);
            $record = $this->parkingRecordRepository->createEntryRecord($vehicle, $availableSpace);
            event(new VehicleEntered($record));
            return $record;
        });
    }
    /**
     * 處理車輛出場邏輯。
     * @throws RecordNotFoundException 如果找不到未出場記錄
     */
    public function recordVehicleExit(string $licensePlate): EntryExitRecord
    {
        return DB::transaction(function () use ($licensePlate) {
            $record = $this->parkingRecordRepository->findUnpaidRecordByLicensePlate($licensePlate);
            if (!$record) {
                throw new RecordNotFoundException("No pending entry record found for license plate: {$licensePlate}");
            }
            $parkingSpace = $record->parkingSpace;
            if (!$parkingSpace) {
                 throw new \Exception("Associated parking space not found for record ID: {$record->id}");
            }
            $this->parkingRecordRepository->updateExitRecord($record);
            event(new VehicleExited($record));
            return $record;
        });
    }
}
