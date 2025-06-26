<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Modules\User\Models\Role;
use App\Modules\Parking\Models\ParkingLot;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $parkingLot = ParkingLot::first();
        if (!$parkingLot) {
            $this->call(ParkingLotSeeder::class);
            $parkingLot = ParkingLot::first();
        }
        $adminRole = Role::where('name', 'admin')->first();
        $securityRole = Role::where('name', 'security')->first();
        $userRole = Role::where('name', 'user')->first();
        // Create a default admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'parking_lot_id' => $parkingLot->id,
        ]);
        $adminUser->roles()->attach($adminRole);
        // Create a default security user
        $securityUser = User::factory()->create([
            'name' => 'Security Guard',
            'email' => 'security@example.com',
            'password' => bcrypt('password'),
            'parking_lot_id' => $parkingLot->id,
        ]);
        $securityUser->roles()->attach($securityRole);
        // Create 5 regular users
        User::factory()->count(5)->create()->each(function ($user) use ($userRole) {
            $user->roles()->attach($userRole);
        });
    }
}
