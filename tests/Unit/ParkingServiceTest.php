<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Modules\Parking\Services\ParkingService;
use App\Modules\Parking\Repositories\Contracts\ParkingRecordRepositoryInterface;
use Mockery;
use App\Modules\Parking\Models\EntryExitRecord;
use App\Modules\Parking\Models\Vehicle;
use App\Modules\Parking\Models\ParkingSpace;
use App\Modules\Parking\Models\ParkingLot;
use App\Exceptions\NoAvailableSpaceException;
use Illuminate\Support\Facades\DB;
class ParkingServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::swap(Mockery::mock('Illuminate\Database\DatabaseManager'));
        DB::shouldReceive('transaction')->andReturnUsing(function($callback) {
            return $callback();
        });
        Vehicle::unguard();
        ParkingSpace::unguard();
        EntryExitRecord::unguard();
        $mockVehicle = Mockery::mock(Vehicle::class);
        $mockVehicle->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $mockVehicle->shouldReceive('getAttribute')->with('user_id')->andReturn(null);
        $mockVehicle->shouldReceive('firstOrCreate')->andReturn($mockVehicle);
        $mockQueryBuilder = Mockery::mock('Illuminate\Database\Eloquent\Builder');
        $mockQueryBuilder->shouldReceive('where')->andReturn($mockQueryBuilder);
        $mockQueryBuilder->shouldReceive('lockForUpdate')->andReturn($mockQueryBuilder);
        $mockParkingSpace = Mockery::mock(ParkingSpace::class);
        $mockParkingSpace->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $mockParkingSpace->shouldReceive('getAttribute')->with('parking_lot_id')->andReturn(1);
        $mockParkingSpace->shouldReceive('update')->andReturn(true);
        $mockQueryBuilder->shouldReceive('first')->andReturn($mockParkingSpace);
        ParkingSpace::shouldReceive('where')->andReturn($mockQueryBuilder);
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    public function testRecordVehicleEntrySuccessfully()
    {
        $repository = Mockery::mock(ParkingRecordRepositoryInterface::class);
        $mockEntryExitRecord = Mockery::mock(EntryExitRecord::class);
        $mockEntryExitRecord->shouldReceive('load')->andReturn($mockEntryExitRecord);
        $repository->shouldReceive('createEntryRecord')->andReturn($mockEntryExitRecord);
        \Illuminate\Support\Facades\Event::fake();
        $service = new ParkingService($repository);
        $result = $service->recordVehicleEntry('ABC-123', 1);
        $this->assertInstanceOf(EntryExitRecord::class, $result);
        \Illuminate\Support\Facades\Event::assertDispatched(\App\Modules\Parking\Events\VehicleEntered::class);
    }
    public function testRecordVehicleEntryThrowsNoAvailableSpaceException()
    {
        $mockQueryBuilder = Mockery::mock('Illuminate\Database\Eloquent\Builder');
        $mockQueryBuilder->shouldReceive('where')->andReturn($mockQueryBuilder);
        $mockQueryBuilder->shouldReceive('lockForUpdate')->andReturn($mockQueryBuilder);
        $mockQueryBuilder->shouldReceive('first')->andReturn(null);
        ParkingSpace::shouldReceive('where')->andReturn($mockQueryBuilder);
        $repository = Mockery::mock(ParkingRecordRepositoryInterface::class);
        $service = new ParkingService($repository);
        $this->expectException(NoAvailableSpaceException::class);
        $service->recordVehicleEntry('XYZ-789', 1);
    }
}
