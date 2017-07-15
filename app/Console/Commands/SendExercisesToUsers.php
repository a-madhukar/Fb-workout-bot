<?php

namespace App\Console\Commands;

use App\Messenger\BotResponse;
use App\User;
use Illuminate\Console\Command;

class SendExercisesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercises:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends exercises to the subscribed users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        BotResponse::handle(collect([]), User::pluck('fb_profile_id')); 
    }
}
