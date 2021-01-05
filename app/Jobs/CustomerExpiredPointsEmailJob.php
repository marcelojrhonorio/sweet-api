<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Customers;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerExpiredPoint;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerExpiredPointsEmailJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    private $timeout = 300;

    private $customerId;

    private $pointsSumary;

    private $customerExpiredPointId;

    private $endpoint;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pointsSumary, $customerId, $customerExpiredPointId)
    {
        $this->pointsSumary = $pointsSumary;
        $this->customerId = $customerId;
        $this->customerExpiredPointId = $customerExpiredPointId;
        $this->endpoint = 'https://transacional.allin.com.br/api';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = $this->renewToken();

        $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token=' . $token);

        $customer              = Customers::find((int) $this->customerId);
        $customerExpiredPoints = CustomerExpiredPoint::find((int) $this->customerExpiredPointId);

        $html = view('emails.customers.expired-points')->with([
            'pointsSumary' => $this->pointsSumary,
            'customer' => $customer,
            'customerExpiredPoint' => $customerExpiredPoints,
        ]);

        $json = [
            'nm_envio'        => $customer->email,
            'nm_email'        => $customer->email,
            'nm_subject'      => 'Nos sentimos no dever de lhe informar!',
            'nm_remetente'    => 'Sweet Bonus',
            'email_remetente' => 'envio@sweetbonusclub.com',
            'nm_reply'        => 'envio@sweetbonusclub.com',
            'dt_envio'        => date('Y-m-d'),
            'hr_envio'        => date('H:i'),
            'html'            => base64_encode(mb_convert_encoding($html, "HTML-ENTITIES", "UTF-8")),
        ];

        $json = json_encode($json);

        $curl_post_data = ['dados' => $json];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        Log::debug('[EXPIRATION]' . $curl_response);
        
    }

    /**
     * Renew All iN token.
     */
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
}
