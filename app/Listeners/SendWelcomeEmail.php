<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        $user = $event->user;

        Mail::raw('Welcome to our platform!', function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Welcome!');
        });
    }
}
