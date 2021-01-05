<?php

namespace App\Jobs;

use DB;
use Log;
use GuzzleHttp\Client;
use App\Models\Customers;
use App\Models\MobileApp\AppWaitingList;

class DispatchInviteAppJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */    

    private $endpoint;
    private $customer;
    private $type;

    public $timeout = 300;

    public function __construct($data, $type)
    {
        $this->endpoint = 'https://transacional.allin.com.br/api';
        $this->customer = $data;
        $this->type = $type;
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

        $html = view('emails.mobile-app.invite')->with([
            'customer' => $this->customer
        ]);

        $json = [
            'nm_envio'        => $this->customer->fullname,
            'nm_email'        => $this->customer->email,
            'nm_subject'      => 'A Sweet escolheu você: Baixe o app agora!',
            'nm_remetente'    => 'Sweet Bonus',
            'email_remetente' => 'envio@sweetbonusclub.com',
            'nm_reply'        => 'envio@sweetbonusclub.com',
            'dt_envio'        => date('Y-m-d'),
            'hr_envio'        => date('H:i'),
            'html'            => base64_encode($html),
        ];

        $json = json_encode($json); 

        $curl_post_data = ['dados' => $json]; 

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        Log::debug($curl_response);

        if(('waiting_list' === $this->type) && (strpos($curl_response, 'sucesso') !== false)){
            $appWaitingList = AppWaitingList::where('customers_id', $this->customer->id)->first();
            $appWaitingList->delete();
        }    
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

    
}
