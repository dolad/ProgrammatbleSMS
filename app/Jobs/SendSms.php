<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $client; // twilio client
    private $twilioNumber; // retrieved from .env
    private $to; // message sending to
    private $body; // body of message

    /**
     * Create a new job instance.
     *
     * @return void
     * @param $to string number to send this to
     * @param $body string message to send
     * @throws ConfigurationException
     */
    public function __construct($to, $body)
    {
        $accountSid = 'AC2a8663f8755eaa7ad78def6946defbf8';
        $authToken = '53a87df847c473ccaaa4ad81f95cb930';
        $this->twilioNumber = '+12015142556';

        $this->client = new Client($accountSid, $authToken);
        $this->to = $to;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->client->messages->create(
                $this->to,
                [
                    "from" => $this->twilioNumber,
                    "body" => $this->body
                ]
            );
        } catch (TwilioException $e) {
            dd($e);
        }
    }
}
