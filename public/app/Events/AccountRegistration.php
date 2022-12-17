<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccountRegistration
{
    // use Dispatchable, InteractsWithSockets, SerializesModels;

    // /**
    //  * Create a new event instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     //
    // }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }

    // added part

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User $user
     * @var User Type $user_type
     */
    public $user;
    public $user_type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $user_type = "admin")
    {
        $this->user     = $user;
        $this->user_type= $user_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }


}
