<?php

namespace App\Listeners;

use App\Events\ProductCreating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UploadProductImages
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCreating $event): void
    {
        //
    }
}
