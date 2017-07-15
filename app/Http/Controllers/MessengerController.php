<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messenger\BotManager; 

class MessengerController extends Controller
{
    //

	/**
	 * Respond to fb's webhook callback
	 * @return String 
	 */
	public function respond()
	{
		info("messenger input"); 
		info(request()->all()); 
		info(json_encode(request()->all())); 

		BotManager::handle(); 

		return "done"; 
	}

}
