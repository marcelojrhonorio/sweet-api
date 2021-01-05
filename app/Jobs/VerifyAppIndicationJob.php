<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Customers;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\MobileApp\AppValidatedIndication;

class VerifyAppIndicationJob extends Job
{
    private $timeout = 300;

    private $customerId;

    private $indicatedId;

    private $endpoint;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customers_id, $indicated_id)
    {
        $this->customerId = $customers_id;
        $this->indicatedId = $indicated_id;
        $this->endpoint = 'https://transacional.allin.com.br/api';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $appValidatedIndication = self::createAppValidatedIndication($this->customerId, $this->indicatedId);
        $customer = self::updateCustomerPoints($this->customerId);

        $token = $this->renewToken();

        $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token=' . $token);

        $customer              = Customers::find((int) $this->customerId);

        $html = view('emails.mobile-app.indication')->with([
            'customer' => $customer,
            'name' => explode(" ", $customer->fullname)[0],
        ]);

        $json = [
            'nm_envio'        => $customer->email,
            'nm_email'        => $customer->email,
            'nm_subject'      => 'Temos mais um Sweeter no app graças a você!',
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

    private static function createAppValidatedIndication($customers_id, $indicated_id)
    {
        $appValidatedIndication = new AppValidatedIndication();
        $appValidatedIndication->customers_id = $customers_id;
        $appValidatedIndication->indicated_id = $indicated_id;
        $appValidatedIndication->points = 10;
        $appValidatedIndication->save();

        return $appValidatedIndication;
    }

    private static function updateCustomerPoints($customers_id)
    {
        $customer = Customers::find($customers_id) ?? null;
        
        if($customer) {
            $customer->points = $customer->points + 10;
            $customer->update();
        }

        return $customer;
    }
}
