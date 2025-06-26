<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Modules\Parking\Services\ParkingService;
use App\Http\Requests\Parking\VehicleEntryRequest;
use App\Http\Requests\Parking\VehicleExitRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\NoAvailableSpaceException;
use App\Exceptions\RecordNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
class ParkingController extends Controller
{
    protected ParkingService $parkingService;
    public function __construct(ParkingService $parkingService)
    {
        $this->parkingService = $parkingService;
    }
    /**
     * 處理車輛入場請求。
     */
    public function entry(VehicleEntryRequest $request): JsonResponse
    {
        try {
            $this->authorize('create', \App\Modules\Parking\Models\EntryExitRecord::class);
            $record = $this->parkingService->recordVehicleEntry(
                $request->input('license_plate'),
                $request->input('parking_lot_id')
            );
            return ApiResponse::success($record, 'Vehicle entered successfully.', 201);
        } catch (NoAvailableSpaceException $e) {
            return ApiResponse::error($e->getMessage(), 409);
        } catch (AuthorizationException $e) {
            return ApiResponse::error($e->getMessage(), 403);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred during vehicle entry: ' . $e->getMessage(), 500);
        }
    }
    /**
     * 處理車輛出場請求。
     */
    public function exit(VehicleExitRequest $request): JsonResponse
    {
        try {
            $this->authorize('update', \App\Modules\Parking\Models\EntryExitRecord::class);
            $record = $this->parkingService->recordVehicleExit(
                $request->input('license_plate')
            );
            return ApiResponse::success($record, 'Vehicle exited and fee is being calculated.', 200);
        } catch (RecordNotFoundException $e) {
            return ApiResponse::error($e->getMessage(), 404);
        } catch (AuthorizationException $e) {
            return ApiResponse::error($e->getMessage(), 403);
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred during vehicle exit: ' . $e->getMessage(), 500);
        }
    }
}
