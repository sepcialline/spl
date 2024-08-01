<?php

namespace App\Events;

use App\Models\Rider;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RiderLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lat , $lng;
    /**
     * Create a new event instance.
     */
    public function __construct($lat,$lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('specialline');
        // [
            // new PrivateChannel('channel-name'),
        // ];
    }

    public function broadcastWith(){
        return[
            'lat'=>$this->lat,
            'lng'=>$this->lng
        ];
    }

    public function broadcastAs(){
        return 'rider-location';
    }
}
