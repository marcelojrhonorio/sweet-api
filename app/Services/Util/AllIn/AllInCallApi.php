<?php

namespace App\Services\Util\AllIn;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Log;

class AllInCallApi
{
    private static function prepareParams(string $typeRequest = null, string $_method = null,$json = null)
    {
        switch ($typeRequest) {
            case "GET":
                        if('get_token' === $_method || null===$_method){
                            return  AllInDefaultParams::get();
                        }
                        return  AllInGetParams::get($_method,$json);

            case "POST": return AllInGetParams::get($_method);
        }
    }
    public static function call(string $typeRequest = null,string $_method = null, $json = null,string $key =null)
    {
        $params = self::prepareParams($typeRequest,$_method,$json);

        $client = AllInClientGuzzleUtil::getClient($params['base_uri']);
        try {
            if($json && 'POST' === $typeRequest){
                $data = ($key ? [$key=>\GuzzleHttp\json_encode($json) ] : ["dados"=>\GuzzleHttp\json_encode($json) ]);
            }
            $response = ($json && 'POST' ===$typeRequest ? $client->request($typeRequest,'?' . AllInPrepareRequest::prepareUrlQuery($params),
                ['form_params' =>  $data,]) :
                $client->request($typeRequest,'?' . AllInPrepareRequest::prepareUrlQuery($params)));
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            Log::debug("[SSI] Request Expection , request ->" . Psr7\str($e->getRequest()));
            Log::debug("[SSI] Request Message , message ->" . $e->getMessage());
            Log::debug("[SSI] Request Method, method ->" . $_method);
            if ($e->hasResponse()) {
                Log::debug("[SSI] Request Expection ->" . Psr7\str($e->getResponse()));
            }
        } catch (ConnectException $e) {
            Log::debug("[SSI] Connection expection, request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("[SSI] Connection expection, response ->" . Psr7\str($e->getResponse()));
            }
        } catch (ClientException $e) {
            Log::debug("[SSI] Client expection, request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("[SSI] Client expection, response ->" . Psr7\str($e->getResponse()));
            }
        } catch (BadResponseException $e) {
            Log::debug("[SSI] Bad Response, request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("[SSI] Bad Response, response ->" . Psr7\str($e->getResponse()));
            }
        }
        return null;
    }

    public static function sendFile(string $_method = null, $_file_name = null, $json = null)
    {
        $params = AllInGetParams::get($_method);
        $client = AllInClientGuzzleUtil::getClient($params['base_uri']);
        try {
            $response = $client->post('?' . AllInPrepareRequest::prepareUrlQuery($params),
                [
                        'multipart' =>
                        [
                            [
                                "name" => "dados",
                                "contents"=>\GuzzleHttp\json_encode($json),
                            ],
                            [
                                "name" => "arquivo",
                                "contents"=>fopen($_file_name, 'r'),
                            ]
                        ]
                ]) ;
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            Log::debug("Request Expection , request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Request Expection ->" . Psr7\str($e->getResponse()));
            }
        } catch (ConnectException $e) {
            Log::debug("Connection expection, request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Connection expection, response ->" . Psr7\str($e->getResponse()));
            }
        } catch (ClientException $e) {
            Log::debug("Client expection, request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Client expection, response ->" . Psr7\str($e->getResponse()));
            }
        } catch (BadResponseException $e) {
            Log::debug("Bad Response, request ->" . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::debug("Bad Response, response ->" . Psr7\str($e->getResponse()));
            }
        }
        return null;
    }
}
