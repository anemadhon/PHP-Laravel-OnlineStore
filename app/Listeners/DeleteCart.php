<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Events\Transaction;

class DeleteCart
{
    /**
     * Handle the event.
     *
     * @param  Transaction  $event
     * @return void
     */
    public function handle(Transaction $event)
    {
        Cart::destroy($event->carts->pluck('id'));
    }
}
