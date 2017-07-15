<?php

namespace App\Messenger;

use Illuminate\Database\Eloquent\Model;

class BotEntry extends Model
{

    protected $table = "users"; 



    protected $guarded = ['id'];



    /**
     * Check if a message entry for the user id & the active time exists
     * @param  String $fbUserId 
     * @return Boolean           
     */
    public static function doesExistForActiveTime($fbUserId)
    {
    	return (new static)->getFirstOrNewForUser($fbUserId)
    	->exists; 
    }




    /**
     * Save a new message entry for the user and the active time
     * @param  String $fbUserId 
     * @return $this           
     */
    public static function newEntry($fbUserId)
    {
    	$instance = (new static)->getFirstOrNewForUser($fbUserId); 

    	$instance->save(); 

    	return $instance; 
    }





    /**
     * Get an instance of the fb user based on the senderId & the active time
     * @param  String $fbUserId 
     * @return $this           
     */
    public function getFirstOrNewForUser($fbUserId)
    {
    	return $this->firstOrNew([
    		'fb_profile_id' => $fbUserId, 
			// 'active_time' => env("ACTIVE_TIME","6:00")
    	]); 
    }


}
