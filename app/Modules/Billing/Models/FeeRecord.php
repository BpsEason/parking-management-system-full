<?php
namespace App\Modules\Billing\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Parking\Models\EntryExitRecord;
class FeeRecord extends Model {
    use HasFactory;
    protected $fillable = ['entry_exit_record_id', 'amount', 'paid_amount', 'payment_method', 'paid_at'];
    protected $casts = ['paid_at' => 'datetime'];
    public function entryExitRecord() { return $this->belongsTo(EntryExitRecord::class); }
}
