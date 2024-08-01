<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class TrackingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $Tracking;

    public function __construct($Tracking)
    {
        $this->Tracking = $Tracking;
    }

    public function broadcastOn()
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
