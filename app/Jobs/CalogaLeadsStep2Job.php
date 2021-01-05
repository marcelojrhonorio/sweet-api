<?php

namespace App\Jobs;

use App\Models\Customers;
use App\Traits\AllInToken;
use App\Traits\CalogaLeadTrait;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class CalogaLeadsStep2Job implements ShouldQueue
{
    use Queueable,
    AllInToken,
    SerializesModels,
    InteractsWithQueue,
        CalogaLeadTrait;

    public $timeout = 5000;
    
    private $customer;

    private $yesterday;


    public function __construct($customer_id = null)
    {
        $this->customer = $customer_id ? Customers::find($customer_id) : new Customers;
        $this->yesterday = Carbon::now()->subDay()->toDateString();
    }

    public function handle()
    {
        $email = $this->customer->email;

        $this->customer->allin_bounced = 0;
        $this->customer->allin_send_empty = 0;
        $this->customer->allin_bad_domain = 0;
        $this->customer->allin_not_send = 0;
        $this->customer->allin_send_at = $this->yesterday;

        $token = $this->renewToken();

        if (empty($token)) {
            Log::debug('CalogaLeadsStep2Job: Falha ao gerar token do All iN.');
            return false;
        }

        $delivered = $this->getDelivered($token);
        //verifica se houve envio do AllIn Para o usuario
        if (empty($delivered)) {
            $this->customer->allin_not_send = 1;
            $this->customer->update();
            Log::debug("CalogaLeadsStep2Job: Nenhuma entrega para {$email} ontem.");
            return true;
        }
        // Recuperando o status do ALLIn
        $status = $delivered->itensConteudo_status_envio;
        // Verificação de bounced
        if (preg_match("/(?:bounced)/", $status)) {
            Log::debug("bounce: email - > {$email} Status - > {$status}");
            $this->customer->allin_bounced = 1;
            //Marcar como BadDomain
            if (preg_match("/(?:bounced\ \-\ bad\-domain)/", $status)) {
                Log::debug('Marcar bad domain');
                $this->customer->allin_bad_domain = 1;
            }
            $this->customer->update();
            return true;
        }
        // marcar para sicronização posterior do job de 3 dias, atualizando a data da sicronia e o status
        if ("" === $status) {
            $this->customer->allin_send_empty = 1;
            $this->customer->update();
            // agendar nova jobs para consultar 72h depois
            Log::debug("Status vazio job das 72h disparado -> {$status}");
            $job = (new CalogaLeadsStep3Job($this->customer->id))->onQueue('sweetbonus_caloga_leads_3');
            Queue::later(Carbon::now()->addDays(3), $job);

            return true;
        }

        //Enviar para a caloga
        //If o retorno for que o email já existi marcar como sicronizado do caloga
        //If o retorno for que o não existi marcar como sicronizado do caloga
        Log::debug("Enviar para a Caloga email -> {$email} Status AllIn -> {$status}");

        if ($this->dispatchLead($this->customer)) {
            $this->customer->caloga_send_status = 1;
            $this->customer->update();
            return true;
        }

        $this->customer->caloga_send_at = Carbon::now();
        $this->customer->caloga_send_status = 2;
        $this->customer->update();

        Log::debug("Problem na sicronia com o caloga do email ->!{$email}");

        return false;
    }

    private function getDelivered($token = '')
    {
        $base = 'https://transacional.allin.com.br/api';

        $client = new Client(['base_uri' => $base]);

        $params = [
            'method' => 'lista_enviados_email',
            'output' => 'json',
            'token' => $token,
            'email' => $this->customer->email,
            'data' => $this->yesterday,
            'range' => '1,1',
        ];

        $query = urldecode(http_build_query($params));

        $response = $client->get('?' . $query,
            [
                'headers' => [
                    'cache-control' => 'no-cache',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],

            ]
        );

        return json_decode(substr(substr(stripslashes($response->getBody()->getContents()), 1, -1), 1, -1));
    }
}
