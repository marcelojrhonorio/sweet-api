<?php

namespace App\Listeners;

use GuzzleHttp\Client;
use App\Mail\CustomerCreatedMail;
use App\Mail\CustomerCreated;
use App\Jobs\CustomerCreatedJob;
use App\Events\CustomerCreatedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerCreatedListener
{
    private $endpoint;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->endpoint = 'https://transacional.allin.com.br/api';
    }

    private function renewToken()
    {
        $client = new Client(['base_uri' => $this->endpoint]);

        $params = [
            'method'   => 'get_token',
            'output'   => 'json',
            'username' => env('ALLIN_USER'),
            'password' => env('ALLIN_PASS'),
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query);

        $json = json_decode($response->getBody()->getContents());

        return $json->token;
    }

    /**
     * Handle the event.
     *
     * @param  CustomerCreatedEvent  $event
     */
    public function handle(CustomerCreatedEvent $event)
    {
        $token = $this->renewToken();

        $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&token=' . $token);

        $html = view('emails.customers.created')->with([
            'customer' => $event->customer,
            'password' => $event->password,
        ]);

        $json = [
            'nm_envio'        => $event->customer->fullname,
            'nm_email'        => $event->customer->email,
            'nm_subject'      => 'Bem-Vindo ao Sweet Media!',
            'nm_remetente'    => 'Sweet Media',
            'email_remetente' => 'envio@qualadicadehoje.com',
            'nm_reply'        => 'envio@qualadicadehoje.com',
            'dt_envio'        => date('Y-m-d'), // '2018-04-13' | date('Y-m-d'),
            'hr_envio'        => date('H:i'), // '16:30' | date('H:i'),
            'html'            => base64_encode($html),
        ];

        $json = json_encode($json);

        $curl_post_data = ['dados' => $json];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        // dd($curl_response);

        // $job = new CustomerCreatedJob($event->customer, $event->password);
        // dispatch($job);

        // Mail::to($event->customer->email)->send(new CustomerCreated());
    }
}
