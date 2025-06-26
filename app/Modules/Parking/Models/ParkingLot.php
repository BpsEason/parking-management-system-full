<?php
namespace App\Modules\Parking\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Billing\Models\RatePlan;
use App\Models\User; // Use base User model
class ParkingLot extends Model {
    use HasFactory;
    protected $fillable = ['name', 'address', 'total_spaces', 'contact_person', 'contact_phone'];
    public function parkingSpaces() { return $this->hasMany(ParkingSpace::class); }
    public function vehicles() { return $this->hasMany(Vehicle::class); }
    public function ratePlans() { return $this->hasMany(RatePlan::class); }
    public function users() { return $this->hasMany(User::class); }
}
