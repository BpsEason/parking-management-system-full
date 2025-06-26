<?php
namespace App\Modules\Parking\Events;
use App\Modules\Parking\Models\EntryExitRecord;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class VehicleExited implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $record;
    public function __construct(EntryExitRecord $record)
    {
        $this->record = $record->load('vehicle', 'parkingSpace');
    }
    public function broadcastOn(): array
    {
        return [
            new \Illuminate\Broadcasting\Channel('parking-lot.' . $this->record->parking_lot_id),
        ];
    }
    public function broadcastAs(): string
    {
        return 'vehicle.exited';
    }
}
