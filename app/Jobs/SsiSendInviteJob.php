<?php

namespace App\Jobs;

use App\Models\Customers;
use App\Services\AllInService;

class SsiSendInviteJob extends Job
{
    private $timeout = 300;

    private $_respondent_id;
    private $_url_research;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $respondent_id = 0, string $url_research = '')
    {
        //
        $this->_respondent_id = $respondent_id;
        $this->_url_research = $url_research;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allInService = new AllInService('QUALADICA');
        $allInToken = allInService::getToken();

        $customer = Customers::find($this->_respondent_id);

        // Abrir a conexão com o CURL
        $curl = curl_init("https://transacional.allin.com.br/api/?method=enviar_email&output=json&encode=UTF8&token={$allInToken}");

        $html = view('emails.ssi.research')->with([
            'url_research' => $this->_url_research, // consultar o projeto e o respondent
        ]);

        // Enviar email
        $json = [
            'nm_envio' => $customer->fullname,
            'nm_email' => $customer->email,
            'nm_subject' => 'Até 100 pontos em poucos minutos. Participe dessa pesquisa!',
            'nm_remetente' => 'Sweet Bonus',
            'email_remetente' => 'envio@qualadicadehoje.com',
            'nm_reply' => 'envio@qualadicadehoje.com',
            'dt_envio' => date('Y-m-d'),
            'hr_envio' => date('H:i'),
            'html' => base64_encode($html),
        ];

        $json = json_encode($json);

        $curl_post_data = ['dados' => $json];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
    }
}
