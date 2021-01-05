<?php

namespace App\Services\Util\AllIn;

use Log;
use GuzzleHttp\Client;

class AllInGetToken
{
    public static function getToken()
    {
        // $json = AllInCallApi::call('GET','get_token');
        // if (null !== $json && property_exists($json, 'token')) {
        //     return $json->token;
        // }
        // return '';

        $token    = null;
        $attempts = 11;

        while ((null === $token) && ($attempts > 0)) {
            $client = new Client(['base_uri' => 'https://painel02.allinmail.com.br/allinapi']);

            $params = [
                'method' => 'get_token',
                'output' => 'json',
                'username' => env('ALLIN_MARKETING_USER','sweetbonus_allinapi'),
                'password' => env('ALLIN_MARKETING_PASS', 'CE7Y6U2E'),
            ];
    
            $query = urldecode(http_build_query($params));
    
            $response = $client->get('?' . $query);
    
            $json = json_decode($response->getBody()->getContents());
    
            $token = $json->token ?? null;

            if ($attempts < 11) {
                Log::debug('[SSI] tentativa de nº ' . $attempts . ' de gerar o token. Token retornado: ' . $token);
            }

            $attempts = $attempts - 1;            
        }

        Log::debug('[SSI] token -> ' . $token);

        return $token;     
    }
}
