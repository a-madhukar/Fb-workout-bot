<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookVerificationController extends Controller
{
    //

	public function verify()
	{
		info("facebook verify challenge"); 
		
		info(request()->all()); 

		if(request()->hub_verify_token != env("FB_VERIFY_TOKEN","eywil-bot-says-hello"))
			return response()->json("failed", 400); 

		return request()->hub_challenge; 
	}
    
}
