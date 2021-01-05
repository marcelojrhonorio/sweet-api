<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait AllInToken
{
    public function renewToken()
    {
        $base = 'https://transacional.allin.com.br/api';

        $client = new Client([
            'base_uri' => $base,
        ]);

        $params = [
            'method'   => 'get_token',
            'output'   => 'json',
            'username' => env('ALLIN_USER'),
            'password' => env('ALLIN_PASS'),
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query);

        $json = json_decode($response->getBody()->getContents());

        return $json->token ?? null;
    }
}
