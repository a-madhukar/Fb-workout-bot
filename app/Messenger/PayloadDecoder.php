<?php 

namespace App\Messenger; 


class PayloadDecoder
{


	public $payload; 



	public function __construct($payload)
	{
		$this->payload = static::buildPayload($payload); 
	}





	/**
	 * New up the instance 
	 * @param  Array $payload optional
	 * @return $this          
	 */
	public static function build($payload = null)
	{
		return (new static($payload ?: request()->all())); 
	}




	/**
	 * Create a collection of all the sender ids that the bot has to respond to.
	 * @return Collection 
	 */
	public function allSenderIds()
	{
		$items = $this->getEntryItems()
		->map(function($entry){
			return $this->getMessagingItems($entry); 
		})->map(function($messaging){
			$sender = $this->getSenderItem($messaging)->flatten(); 
			info("sender"); 
			info($sender); 
			
			return $sender; 
		})->flatten();

		info("sender ids items"); 
		info($items); 
		return $items; 
	}




	/**
	 * Transform the payload into the following array
	 * @param  Collection $entry 
	 * @return Array        
	 */
	public function transform($entry)
	{
		return collect([
			'sender_id' => $entry->pluck('sender')
		]); 
	}




	/**
	 * Get teh sender key depending on the message object
	 * @param  Collection $message =
	 * @return Collection          
	 */
	public function getSenderItem($message)
	{
		return $message->pluck('sender'); 
	}





	/**
	 * Get the messaging items based on the provided entry object
	 * @param  Collection $entry 
	 * @return Collection        
	 */
	protected function getMessagingItems($entry)
	{
		return $entry->get('messaging'); 
	}




	/**
	 * Get the entry items
	 * @return collection 
	 */
	public function getEntryItems()
	{
		// dd($this->payload->get('entry')); 
		return $this->payload->get('entry'); 
	}




	/**
	 * Convert fb's payload into deep collections
	 * @param  Array $payload 
	 * @return Collection          
	 */
	public static function buildPayload($payload)
	{
		return static::recursiveCollection($payload);
	}



	/**
	 * Loop through the arrays recursively and convert them to arrays
	 * @param  Mixed $payload 
	 * @return Collection          
	 */
	public static function recursiveCollection($payload)
	{
		if(!is_array($payload))
			return $payload; 

		foreach($payload as $key => $value)
		{
			if(is_array($value))
				$payload[$key] = self::recursiveCollection($value); 
		}

		return collect($payload); 
	}




	/**
	 * Check if the payload contains the delivery key
	 * @return boolean 
	 */
	public function containsDeliveryKey()
	{
		$keys = $this->getEntryItems()
		->pluck('messaging')
		->first()
		->first()
		->keys()
		->contains('delivery');  

		return $keys;
	}


}