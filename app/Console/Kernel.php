<?php

namespace App\Console;

use App\Models\Mensagem;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $mensagens = Mensagem::all();
            foreach($mensagens as $msg){
                foreach($msg->tokens as $token){
                    if($token->pivot->expired_in <= Carbon::now()){
                        echo "Token ". $token->pivot->token . "expirado! Apagando...\n";
                        $msg->tokens()->detach($token);
                    }
                }
            }
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
