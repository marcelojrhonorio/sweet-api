<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Services\Util\AllIn\AllInGetToken;

class EmailListDataService
{
    public static function insertData ($_project_name = null, $listData = null) {
        Log::debug('[SSI] teste project name: ' . $_project_name);
        Log::info(print_r($listData, true));

        $token = AllInGetToken::getToken();

        $curl = curl_init('https://painel02.allinmail.com.br/allinapi/?method=inserir_email_base&output=json&token=' . $token);

        $json = [
            'nm_lista' => $_project_name,
            'campos' => 'nm_email; nm_url; nm_id',
            'valor' => $listData['nm_email'] . ';' . $listData['nm_url'] . ';' . $listData['nm_id'] 
        ];

        $json = json_encode($json);

        $curl_post_data = ['dados_email' => $json];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        Log::debug($curl_response);
    }
}