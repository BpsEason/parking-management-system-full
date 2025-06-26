<?php
namespace App\Modules\Parking\Repositories\Contracts;
use App\Modules\Parking\Models\EntryExitRecord;
use App\Modules\Parking\Models\Vehicle;
use App\Modules\Parking\Models\ParkingSpace;
use Illuminate\Database\Eloquent\Collection;
interface ParkingRecordRepositoryInterface
{
    public function createEntryRecord(Vehicle $vehicle, ParkingSpace $space): EntryExitRecord;
    public function findUnpaidRecordByLicensePlate(string $licensePlate): ?EntryExitRecord;
    public function updateExitRecord(EntryExitRecord $record): bool;
    public function findById(int $id): ?EntryExitRecord;
    public function getOccupiedSpacesByLot(int $lotId): Collection;
}
