<?php

namespace App\Listeners;

use App\Messenger\BotResponse; 
use App\Events\UserMessagedPage;
use App\Messenger\PayloadDecoder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendResponseMessage
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
     * @param  UserMessagedPage  $event
     * @return void
     */
    public function handle(UserMessagedPage $event)
    {
        
        BotResponse::handle($event->payload); 

        // $senderIds = PayloadDecoder::build(request()->all())
        // ->allSenderIds()
        // ->map(function($senderId){
        //     info("sender Id inside the loop");
        //     info($senderId);  
        //     return $this->buildMessageData($senderId); 
        // }); 

    }






}
