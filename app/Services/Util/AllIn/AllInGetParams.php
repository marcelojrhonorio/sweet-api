<?php

namespace App\Services\Util\AllIn;

class AllInGetParams
{
    public static function get(string $_method = null,array $urlParams = null)
    {
        $token = AllInGetToken::getToken();
        $params = [
            "base_uri" => env('ALLIN_MARKETING_BASE_URI', 'https://painel02.allinmail.com.br/allinapi/'),
            "method" => $_method,
            "output" => "json",
            "token" =>$token,
        ];
        if(null!==$urlParams || !empty($urlParams) ){
            $params+=$urlParams;
        }
        return $params;
    }
}
