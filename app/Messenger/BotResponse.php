<?php 

namespace App\Messenger; 

use App\Services\HttpClient\Http;


class BotResponse
{



	protected $payload; 



	public function __construct($payload)
	{
		$this->payload = $payload; 
	}




	/**
	 * New up the instance and delegate to the execute method
	 * @param  Array $payload 
	 * @return $this          
	 */
	public static function handle($payload, $senderIds = null)
	{
		return (new static($payload))->execute($senderIds); 
	}





	/**
	 * Loop through the sender ids, build the payloads and make post requests
	 * @return $this 
	 */
	public function execute($senderIds = null)
	{
		$senderIds = $senderIds ?: $this->payload->allSenderIds(); 
		// ->reject(function($senderId){
		// 	return BotEntry::doesExistForActiveTime($senderId); 
		// })
        $senderIds->map(function($senderId){
            info("sender Id inside the loop");
            info($senderId);  
            return $this->buildMessageData($senderId); 
        })
        ->map(function($payload){
            info("individual payload"); 
            info($payload); 
            $response = $this->respondToUser($payload); 
            // return $response;
            return BotEntry::newEntry($payload['recipient']['id']); 
        });

		return $this; 
	}



	/**
	 * Build the message data payload for each senderId
	 * @param  String $senderId 
	 * @return Array           
	 */
    public function buildMessageData($senderId)
    {
        info("building message data for $senderId"); 
        return [
            'recipient' => [
                'id' => $senderId
            ], 
            'message' => [
	            // 'text' => BotMessageText::randomResponse()
                'text' => BotExercise::handle(),
            ]
        ]; 
    }




    /**
     * Make a post request to the given endpoint
     * @param  Array $payload 
     * @return json          
     */
    public function respondToUser($payload)
    {
        $url = env("MESSENGER_RESPONSE_LINK") . env("FB_PAGE_TOKEN"); 

        info("responding to the user"); 
        info($url); 
        info($url, $payload); 

       return app(Http::class)->post($url, $payload); 
    }

}