<?php

namespace App\Listeners;

use App\Events\OrderWasPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderConfirmationMail
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
     * @param  OrderWasPlaced  $event
     * @return void
     */
    public function handle(OrderWasPlaced $event)
    {
        \Mail::send('emails.order-confirmation', ['order' => $event->order], function($m) use($event) {
            $m->from(config('site.email.support'), config('site.name'));
            $m->to($event->order->email)->subject("Your Zugy order confirmation and receipt [#{$event->order->id}]");
        });
    }
}