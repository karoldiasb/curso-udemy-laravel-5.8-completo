<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Mail\NovoAcesso;
use Illuminate\Support\Facades\Mail;

class LoginListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        info('Logou');
        info($event->user->name);
        info($event->user->email);

        $quando = now()->addMinutes(2);
        Mail::to($event->user->email)
            // ->send(new NovoAcesso($event->user));
            // ->queue(new NovoAcesso($event->user)); //coloca o email em uma fila (utilização com redis).
            ->later($quando, new NovoAcesso($event->user)); //posterga eventos
    }
}
