<?php
namespace App\Http\Requests\Parking;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
class VehicleEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 只有擁有 'security' 或 'admin' 角色的使用者才能記錄車輛入場
        return $this->user() && ($this->user()->roles->contains('name', 'security') || $this->user()->roles->contains('name', 'admin'));
    }
    public function rules(): array
    {
        return [
            'license_plate' => ['required', 'string', 'max:20'],
            'parking_lot_id' => ['required', 'integer', 'exists:parking_lots,id'],
        ];
    }
}
