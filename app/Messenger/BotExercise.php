<?php

namespace App\Messenger;

use Illuminate\Database\Eloquent\Model;

class BotExercise extends Model
{
    


	public static function handle()
	{
		return (new static)->randomize(); 
	}




	public function randomize()
	{
		$exercise = $this->all()->shuffle()->random(); 

		return sprintf("Hey! \n\nYou need to drop whatever you're doing and do the following: \n\n%s \t %s \t %s", 
			$exercise->name, 
			rand($exercise->lower_bound, $exercise->upper_bound), 
			$exercise->unit
		); 
	}



}
