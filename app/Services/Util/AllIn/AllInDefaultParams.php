<?php

namespace App\Services\Util\AllIn;

class AllInDefaultParams
{
    public static function get()
    {
        return [
            "base_uri" => env('ALLIN_MARKETING_BASE_URI', 'https://painel02.allinmail.com.br/allinapi/'),
            "method" => "get_token",
            "output" => "json",
            "username" => env('ALLIN_MARKETING_USER','sweetbonus_allinapi'),
            "password" => env('ALLIN_MARKETING_PASS', 'CE7Y6U2E'),
        ];
    }
}
