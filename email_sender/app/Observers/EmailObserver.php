<?php

namespace App\Observers;

use App\Mail\OrderIsPlaced;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;

class EmailObserver
{
    /**
     * Handle the Email "created" event.
     */
    public function created(Email $email): void
    {
        $cartData = json_decode(stripslashes($email->cart));

        Mail::to($email->user_email)
            ->queue(new OrderIsPlaced($email, $cartData));
    }

    /**
     * Handle the Email "updated" event.
     */
    public function updated(Email $email): void
    {
        //
    }

    /**
     * Handle the Email "deleted" event.
     */
    public function deleted(Email $email): void
    {
        //
    }

    /**
     * Handle the Email "restored" event.
     */
    public function restored(Email $email): void
    {
        //
    }

    /**
     * Handle the Email "force deleted" event.
     */
    public function forceDeleted(Email $email): void
    {
        //
    }
}
