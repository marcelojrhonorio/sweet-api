<?php

namespace App\Services;

use App\Services\Util\AllIn\AllInCallApi;

class AllInMarketingService
{
    /**
     * Create a Marekting list
     *
     */
    public static function createMarketingList(string $name = null, array $fields = null)
    {
        $json = [
            "nm_lista" => $name,
            "campos" => $fields
        ];
        return AllInCallApi::call('POST','criarLista',$json);
    }
    // criar metodo listar listas
    public static function getMarkentingList(array $filter = [])
    {
        return AllInCallApi::call('POST','getlistas');
    }
    // criar metodo de enviar lista de email
    public static function sendEmailsFile(string $filename = null, array $_fields = null)
    {
        return AllInCallApi::sendFile('uploadLista',$filename, $_fields);
    }

    public static function createEmailDispatch(array $_fields = null)
    {
        return AllInCallApi::call('POST','criar_envio', $_fields,"dados_envio");
    }

    public static function emailTestDispatch(int $_campaing_id = null)
    {
        $json=['campanha_id'=>$_campaing_id];
        return AllInCallApi::call('GET','enviar_teste',$json);
    }

    public static function emailDispatch(int $_campaing_id = null)
    {
        $json=['campanha_id'=>$_campaing_id];
        return AllInCallApi::call('GET','enviar_final',$json);
    }
}
