<?php

namespace App\Jobs;

use App\Models\Customers;
use App\Traits\AllInToken;
use App\Traits\CalogaLeadTrait;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CalogaLeadsStep3Job extends Job
{
    use AllInToken, CalogaLeadTrait;

    private $customer;

    public $timeout = 5000;
    
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer_id = null)
    {
        //
        $this->customer = $customer_id ? Customers::find($customer_id) : new Customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->customer->email;
        $this->customer->allin_bounced = 0;
        $this->customer->allin_send_empty = 0;
        $this->customer->allin_bad_domain = 0;

        Log::debug('Start the job 3');
        // consultar a resposta do AllIn
        $token = $this->renewToken();

        $delivered = $this->getDelivered($token);

        if (empty($token)) {
            Log::debug('CalogaLeadsStep2Job: Falha ao gerar token do All iN.');
            return;
        }
        // Verificar se é Bounced
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

        // Enviar para a caloga
        // If o retorno for que o email já existi marcar como sicronizado do caloga
        // If o retorno for que o não existi marcar como sicronizado do caloga
        Log::debug("Enviar para a Caloga email -> {$email} Status AllIn -> {$status}");
        if ($this->dispatchLead($this->customer)) {
            $this->customer->caloga_send_status = 1;
            $this->customer->caloga_send_at = Carbon::now();
            $this->customer->update();
            return true;
        }
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
            'data' => $this->customer->allin_send_at,
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
