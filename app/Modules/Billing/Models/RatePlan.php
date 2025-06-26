<?php
namespace App\Modules\Billing\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Parking\Models\ParkingLot;
class RatePlan extends Model {
    use HasFactory;
    protected $fillable = ['parking_lot_id', 'name', 'description', 'type', 'rules', 'is_active', 'effective_date', 'expiry_date'];
    protected $casts = ['rules' => 'array', 'effective_date' => 'date', 'expiry_date' => 'date'];
    public function parkingLot() { return $this->belongsTo(ParkingLot::class); }
}
