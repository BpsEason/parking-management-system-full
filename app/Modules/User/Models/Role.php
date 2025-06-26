<?php
namespace App\Modules\User\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Role extends Model {
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public function users() { return $this->belongsToMany(\App\Models\User::class, 'role_user'); }
}
