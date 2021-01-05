<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Services\FacebookService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacebookMessengerController extends Controller
{
    //
    private static $token = 'EAAD8LJXa9QwBAHxTPhIO89tF0AZCQHeWwytG5j8lw2GlBR2Qpv7fIQi1ZBizwoHcdRGNQNd79HqqrMh3tWuZByaiBcuI1LJ9VxBBbIfuoMcUvZBtSZCo0Pn5VRQHfbuvVwTlT198r0SZC6YbXVLJzcaQke0kZA2hO4QZAMXVK2DzXgZDZD';
    public function validateToken(Request $request)
    {
        $hub_verify_token = $request->query('hub_verify_token');
        if( $hub_verify_token === self::$token){
            $hub_challenge = $request->query('hub_challenge');
            return response($hub_challenge,200)->header('Content-Type', 'text/plain');
        }
        return response('Forbiden',403)->header('Content-Type', 'text/plain');
    }
    public function postMessage(Request $request)
    {
        $input = $request->all();
        $facebook_id = (int) $input['entry'][0]['messaging'][0]['sender']['id'];
        if (array_key_exists('referral', $input['entry'][0]['messaging'][0])) {
            $customer_id = (int) $input['entry'][0]['messaging'][0]['referral']['ref'];
            if (FacebookService::verifyCustomer($customer_id, $facebook_id)) {
                FacebookService::syncFacebook($customer_id, $facebook_id);
                $this->sendMessage($facebook_id);
            }
        }

        if (array_key_exists('message', $input['entry'][0]['messaging'][0])) {
                $message = $input['entry'][0]['messaging'][0]['message']['text'];
                if('Eu Quero Pontos' === $message){
                    $this->sendMessage($facebook_id, 'Teste do Bot');
                }
        }
        return response('',200)->header('Content-Type', 'text/plain');
    }

    public function sendMessage($facebook_id, string $msg = null)
    {
        try {
            $client = new Client();
            $url = "https://graph.facebook.com/v2.6/me/messages";
            $header = array('content-type' => 'application/json');
            $answer =  $msg ? $msg : "Está é uma mensagem padrão! Você acebou de receber 50 pontos! Que maravilha o/ agora você pode começar a receber nossas promoções e pesquisas atráves daqui do facebook.
                        Para dúvidas sobre o site Sweetbonus.com.br nosso canal de comunicação é o contato@sweetpanels.com.
                        Por fim, para parar de receber comunicação por aqui pelo facebook basta responder Sair.";
            $response = ['recipient' => ['id' => $facebook_id], 'message' => ['text' => $answer], 'access_token' => self::$token];
            $response = $client->post($url, ['query' => $response, 'headers' => $header]);
            return true;
        } catch(RequestException $e) {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            return $response;
        }
    }

}
