<?php
namespace App\Modules\Parking\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vehicle extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = ['parking_lot_id', 'license_plate_number', 'user_id', 'model'];
    public function user() { return $this->belongsTo(\App\Models\User::class); }
    public function parkingLot() { return $this->belongsTo(ParkingLot::class); }
}
