<?php
namespace App\Modules\Parking\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Billing\Models\FeeRecord;
class EntryExitRecord extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = ['parking_lot_id', 'vehicle_id', 'parking_space_id', 'entry_time', 'exit_time', 'entry_gate', 'exit_gate', 'total_fee', 'is_paid'];
    protected $casts = ['entry_time' => 'datetime', 'exit_time' => 'datetime'];
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function parkingSpace() { return $this->belongsTo(ParkingSpace::class); }
    public function parkingLot() { return $this->belongsTo(ParkingLot::class); }
    public function feeRecord() { return $this->hasOne(FeeRecord::class); }
}
