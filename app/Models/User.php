<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Parking\Models\Vehicle;
use App\Modules\User\Models\Role;
class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $fillable = ['name', 'email', 'password', 'parking_lot_id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    public function vehicles() { return $this->hasMany(Vehicle::class); }
    public function roles() { return $this->belongsToMany(Role::class, 'role_user'); }
    public function parkingLot() { return $this->belongsTo(\App\Modules\Parking\Models\ParkingLot::class); }
}
