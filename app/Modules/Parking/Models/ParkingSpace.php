<?php
namespace App\Modules\Parking\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ParkingSpace extends Model {
    use HasFactory;
    protected $fillable = ['parking_lot_id', 'space_number', 'type', 'status'];
    public function parkingLot() { return $this->belongsTo(ParkingLot::class); }
}
