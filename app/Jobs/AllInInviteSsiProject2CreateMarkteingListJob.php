<?php

namespace App\Jobs;

use App\Services\AllInMarketingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AllInInviteSsiProject2CreateMarkteingListJob extends Job
{

    protected $name_list;

    public $timeout = 5000;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $name_list)
    {
        $this->name_list = $name_list;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $html = view('emails.ssi.marketing-research');

        $newtimestamp = strtotime(date('Y-m-d H:i:s')." + 20 minute");
        $dateStart = date('Y-m-d H:i:s', $newtimestamp);
        // dados para o email
        $data = [
            'nm_campanha'       => "Ssi Email Marketing ".$this->name_list,
            'nm_subject'        => 'Até 60 pontos em poucos minutos. Participe dessa pesquisa '.date('d').'/'.date('m').'!',
            'nm_remetente_nome' => 'Sweet Bonus',
            'nm_remetente'      => 'envio@sweetbonusclub.com',
            'nm_reply'          => 'envio@sweetbonusclub.com',
            'dt_inicio'         => $dateStart,
            'nm_lista'          => $this->name_list,
            'nm_html'           => base64_encode(mb_convert_encoding($html, "HTML-ENTITIES", "UTF-8")),
        ];

        // Criar Envio
        $emailMarketingCreated = AllInMarketingService::createEmailDispatch($data);
        if(!empty($emailMarketingCreated) && property_exists($emailMarketingCreated,'campanha_id')){
            $job =( new AllInInviteSsiProject3DispatchEmailsJob( (int) $emailMarketingCreated->campanha_id))->onQueue('api_ssi_invite_project_all_marketing_email_3')->delay(Carbon::now()->addMinutes(15));
            dispatch($job);
        }
    }
}
