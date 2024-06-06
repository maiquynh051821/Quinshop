<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $customer;
    protected $updatedCarts;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $customer, $updatedCarts)
    {
        $this->email = $email;
        $this->customer = $customer;
        $this->updatedCarts = $updatedCarts;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new OrderShipped($this->customer, $this->updatedCarts));
    }
}
