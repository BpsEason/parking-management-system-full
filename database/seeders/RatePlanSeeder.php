<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Billing\Models\RatePlan;
use App\Modules\Parking\Models\ParkingLot;
class RatePlanSeeder extends Seeder
{
    public function run(): void
    {
        $parkingLots = ParkingLot::all();
        if ($parkingLots->isEmpty()) {
            $this->call(ParkingLotSeeder::class);
            $parkingLots = ParkingLot::all();
        }
        foreach ($parkingLots as $lot) {
            RatePlan::create([
                'parking_lot_id' => $lot->id,
                'name' => 'Hourly Rate Plan',
                'description' => 'Default hourly rate for all vehicle types.',
                'type' => 'hourly',
                'rules' => [
                    'hourly_rate' => 50,
                    'max_daily_fee' => 300,
                    'free_minutes' => 15
                ],
                'is_active' => true,
            ]);
            RatePlan::create([
                'parking_lot_id' => $lot->id,
                'name' => 'Monthly Pass Plan',
                'description' => 'Flat fee for monthly parking.',
                'type' => 'monthly',
                'rules' => [
                    'monthly_fee' => 3000,
                    'unlimited_access' => true,
                ],
                'is_active' => true,
            ]);
        }
    }
}
