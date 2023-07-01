<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\WelcomeMessage;
use Throwable;

class UploadCSVProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $header;
    public $timeout = 0;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $header)
    {
        $this->data   = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->data as $customer){
            $row = array_combine($this->header, $customer);
            $customerExist = Customer::where('email', $row['email'])->first() || Customer::where('mobile_number', $row['mobile_number'])->first();
            if($customerExist)
                continue;
            $customer = Customer::create([
                'name' => $customer[0],
                'email' => $row['email'],
                'mobile_number' => $row['mobile_number'],
            ]);
            $customer->notify(new WelcomeMessage);
        }
    }
        public function failed(Throwable $exception)
    {
        Customer::truncate();
    }
}