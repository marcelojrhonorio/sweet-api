<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Ambev\AmbevCustomer;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAmbevEmailsJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    private $ambevCustomer;

    private $endpoint;

    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct($ambevCustomer)
    {
        $this->ambevCustomer = $ambevCustomer;
        $this->endpoint = 'https://transacional.allin.com.br/api';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $token = $this->renewToken();

        $curl = curl_init('https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token=' . $token);

        $urlId = $this->getUrlId($this->ambevCustomer->template);

        $link = 'http://sweet.go2cloud.org/aff_c?offer_id=193&aff_id=1004&url_id=' . $urlId . '&aff_sub=' . $this->ambevCustomer->region . '&aff_sub2=' . $this->ambevCustomer->user_id . '&aff_sub3=' . $urlId . '&USER_ID=' . $this->ambevCustomer->user_id;
        
        $html = view('emails.ambev.' . $this->ambevCustomer->template)->with('link', $link);

        $subject = $this->getEmailSubject($this->ambevCustomer->template);

        $json = [
            'nm_envio'        => $this->ambevCustomer->email,
            'nm_email'        => $this->ambevCustomer->email,
            'nm_subject'      => $subject,
            'nm_remetente'    => 'Ab Inbev',
            'email_remetente' => 'GlobalSolutionsCommunication@AB-inbev.com',
            'nm_reply'        => 'GlobalSolutionsCommunication@AB-inbev.com',
            'dt_envio'        => date('Y-m-d'),
            'hr_envio'        => date('H:i'),
            'html'            => base64_encode(mb_convert_encoding($html, "HTML-ENTITIES", "UTF-8")),
        ];

        $json = json_encode($json);

        $curl_post_data = ['dados' => $json];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);

        Log::debug($curl_response . ' ' . $this->ambevCustomer->user_id) . ' ' . $this->ambevCustomer->email;

        $ambevCustomer = $this->setFiredEmail($this->ambevCustomer->id, $curl_response);

    }

    /**
     * Renew All iN token.
     */
    private function renewToken()
    {
        $client = new Client(['base_uri' => $this->endpoint]);

        $params = [
            'method'   => 'get_token',
            'output'   => 'json',
            'username' => env('ALLIN_USER_QUALADICA'),
            'password' => env('ALLIN_PASS_QUALADICA'),
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query);

        $json = json_decode($response->getBody()->getContents());

        return $json->token;
    }

    private function setFiredEmail($ambevCustomerId, $curl_response)
    {
        $ambevCustomer = AmbevCustomer::find($ambevCustomerId);

        /**
         * Status 0: à ser processado
         * Status 1: processado e disparado
         * Status 2: processado e não disparado
         */
        
        $ambevCustomer->fired_email = 1;

        if(preg_match("/(?:Erro)/", $curl_response))
        {
            $ambevCustomer->fired_email = 2;
            Log::debug("Failed insert email {$ambevCustomer->id}");
        } 

        return $ambevCustomer->update();

    }

    private function getUrlId($template)
    {
        $urlId = [
            '1' => '28',
            '2' => '29',
            '3' => '30',
            '4' => '31',
            '5' => '32',
            '6' => '33',
            '7' => '34',
            '8' => '35',
            '9' => '36',
            '10' => '37',
            '12' => '38',
            '13' => '39',
            '14' => '40',
            '15' => '41',
            '16' => '42',
            '17' => '43',
            '18' => '44',
        ];

        return $urlId[$template];
    }

    private function getEmailSubject($template)
    {
        $languages = [
            '1' => 'Last Call to Complete the ABI Solutions Satisfaction Survey!',
            '2' => 'Dernière chance de remplir le sondage de satisfaction ABI Solutions!',
            '3' => 'Última chamada para completar a Pesquisa de Satisfação Global!',
            '4' => 'Última oportunidad para completar la Encuesta de Satisfacción de Soluciones ABI.',
            '5' => '¡Último aviso para completar la encuesta de satisfacción de AB Soluciones!',
            '6' => 'Laatste oproep om je ABI Solutions tevredenheidsonderzoek af te maken!',
            '7' => 'Letzte Chance, um an der AB InBev Solutions-Zufriedenheitsumfrage teilzunehmen!',
            '8' => 'Ultima chiamata per completare il Sondaggio di Soddisfazione di ABI Solutions!',
            '9' => 'Dernier appel pour compléter le sondage sur la satisfaction des solutions ABI!',
            '10' => 'ABInbev Satisfaction Survey!',
            '12' => 'ABInbev Satisfaction Survey!',
            '13' => 'ABInbev Satisfaction Survey!',
            '14' => 'ABInbev Satisfaction Survey!',
            '15' => 'ABInbev Satisfaction Survey!',
            '16' => 'Last Call to Complete the ABI Solutions Satisfaction Survey!',
            '17' => '¡Última oportunidad para contestar la Encuesta de Satisfacción Global!',
            '18' => 'Last Call to Complete the ABI Solutions Satisfaction Survey!',
        ];

        return $languages[$template];
    }
}
