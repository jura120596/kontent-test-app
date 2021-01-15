<?php

namespace App\Listeners;

use App\Events\ProductChanged;
use App\Mail\ProductChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendProductChangedListener
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
     * @param  ProductChanged  $event
     * @return void
     */
    public function handle(ProductChanged $event)
    {
        Mail::to(config('mail.to.dev'))->send(new ProductChangedNotification());
    }
}
