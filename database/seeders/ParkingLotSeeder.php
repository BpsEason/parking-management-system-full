<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Parking\Models\ParkingLot;
use App\Modules\Parking\Models\ParkingSpace;
use Illuminate\Support\Facades\DB;
class ParkingLotSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 parking lots using factory
        ParkingLot::factory()->count(3)->create()->each(function ($parkingLot) {
            // For each parking lot, create parking spaces
            $spaces = [];
            for ($i = 1; $i <= $parkingLot->total_spaces; $i++) {
                $spaces[] = [
                    'parking_lot_id' => $parkingLot->id,
                    'space_number' => 'A' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'type' => 'general',
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('parking_spaces')->insert($spaces);
        });
    }
}
