<?php

namespace App\Messenger;

use Illuminate\Database\Eloquent\Model;

class BotMessageText extends Model
{
    
    protected $guarded = ['id'];




    public static function randomResponse()
    {
    	$responses = static::all()->shuffle();

    	return $responses->get(array_rand($responses->all()))->response;  
    }




    /**
     * Save a new possible response for the bot
     * @param  String $text 
     * @return $this       
     */
    public static function newResponse($text)
    {
    	$instance = (new static)->firstOrNew([
    		'response' => $text
    	]); 
    	$instance->save(); 
    	return $instance; 
    } 

}
