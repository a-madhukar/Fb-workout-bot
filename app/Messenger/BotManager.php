<?php 

namespace App\Messenger; 

use Carbon\Carbon; 
use App\Events\UserMessagedPage;

class BotManager
{



	/**
	 * 
	 * @var PayloadDecoder
	 */
	protected $payload; 




	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->payload = PayloadDecoder::build(); 
	}




	/**
	 * New up the instance and delegate to the execute method
	 * @return $this 
	 */
	public static function handle()
	{
		return (new static)->execute(); 
	}




	/**
	 * Fire the event if the bot is active and the fb payload doesn't contain the delivery type.
	 * @return $this 
	 */
	public function execute()
	{
		if($this->isNotDeliveryPayload())
			event(new UserMessagedPage($this->payload));

		return $this; 
	}




	/**
	 * Check if the payload fb posted is a message and not delivery
	 * @return boolean 
	 */
	public function isNotDeliveryPayload()
	{
		return !$this->payload->containsDeliveryKey(); 
	}




	/**
	 * Check if the current time is greater than or equal to the set active time
	 * @return Boolean 
	 */
	public function checkValidTime()
	{
		// dd(Carbon::now("Asia/Kuala_Lumpur")); 
		return Carbon::now($this->getTimezone())
		->gte($this->getActiveTime()); 		 
	}




	/**
	 * Get a carbon instance of the set active time 
	 * @return Carbon\Carbon \
	 */
	public function getActiveTime()
	{
		$activeTime = explode(":",env("ACTIVE_TIME","6:00"));
		return Carbon::createFromTime(
			$activeTime[0], 
			$activeTime[1], 
			0, 
			$this->getTimezone()
		); 
	}





	/**
	 * Get the current timezone. Defaults to asia kuala lumpuer
	 * @return String 
	 */
	public function getTimezone()
	{
		return env("TIMEZONE","Asia/Kuala_Lumpur");  
	}

}