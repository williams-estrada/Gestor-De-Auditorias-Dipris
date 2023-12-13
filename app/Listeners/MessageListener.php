<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Usuarios;
use App\Notifications\MessageNotification;
use Illuminate\Support\Facades\Notification;

class MessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        if($event->message->to_user_id == 3){
            Usuarios::where('id', '!=', auth()->user()->id)
                ->each(function(Usuarios $user) use ($event){
                    Notification::send($user, new MessageNotification($event->message));
                });
        }
        else{
            Usuarios::where('id', $event->message->to_user_id)
                ->each(function(Usuarios $user) use ($event){
                    Notification::send($user, new MessageNotification($event->message));
                });
        }
        
    }
}
