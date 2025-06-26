<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Parking\Models\ParkingLot;
class ParkingLotFactory extends Factory
{
    protected $model = ParkingLot::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Parking Lot',
            'address' => $this->faker->address(),
            'total_spaces' => $this->faker->numberBetween(100, 500),
            'contact_person' => $this->faker->name(),
            'contact_phone' => $this->faker->phoneNumber(),
        ];
    }
}
