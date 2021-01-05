<?php

namespace App\Observers;

use GuzzleHttp\Client;
use App\Models\CustomerPasswordReset;

class CustomerPasswordResetObserver
{
    private $endpoint = 'https://transacional.allin.com.br/api';

    public function created(CustomerPasswordReset $reset)
    {
        $this->handle($reset);
    }

    public function updated(CustomerPasswordReset $reset)
    {
        $this->handle($reset);
    }

    private function handle(CustomerPasswordReset $reset)
    {
        return response()->json([date('H:i')]);

        $token = $this->renewToken();

        $curl = curl_init($this->endpoint . '?method=enviar_email&output=json&token=' . $token);

        $html = view('emails.customers.reset')->with([
            'email' => $reset->email,
            'token' => $reset->token,
        ]);

        $json = [
            'nm_envio'        => 'Recuperar senha',
            'nm_email'        => $reset->email,
            'nm_subject'      => 'Sweet Media: Recuperar senha',
            'nm_remetente'    => 'Sweet Media',
            'email_remetente' => 'envio@qualadicadehoje.com',
            'nm_reply'        => 'envio@qualadicadehoje.com',
            'dt_envio'        => date('Y-m-d'), // 2018-04-13 ~ date('Y-m-d'),
            'hr_envio'        => date('H:i'), // 10:23 ~ date('H:i'),
            'html'            => base64_encode($html),
        ];

        $json = json_encode($json);

        $curl_post_data = ['dados' => $json];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
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
