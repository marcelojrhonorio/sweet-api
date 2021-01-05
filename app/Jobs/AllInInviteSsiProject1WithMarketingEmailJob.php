<?php

namespace App\Jobs;

use App\Console\Commands\DispatchCalogaLeadsStep1Job;
use App\Models\Customers;
use App\Models\Ssi\SsiProject;
use App\Services\AllInMarketingService;
use App\Services\EmailListService;
use Illuminate\Support\Facades\Log;

class AllInInviteSsiProject1WithMarketingEmailJob extends Job
{
    protected $_project_id;

    public $timeout = 5000;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $project_id = null)
    {
        $this->_project_id = $project_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $project = SsiProject::find($this->_project_id);
        $_project_name = EmailListService::getProjectFileListName($project->id);

        $_filename = storage_path()."/".$_project_name.".csv";

        if(EmailListService::createFile($project,$_filename)){
            Log::debug('[SSI] arquivo criado: ' . $_filename);
            // if(AllInMarketingService::createMarketingList($_project_name,EmailListService::getRequestCreateListFields())){
            //     // AllInMarketingService::sendEmailsFile($_filename,EmailListService::getRequestSendEmailFields($_project_name));
                
            //     // insert lista data.
            //     EmailListService::callInsertListData($project, $_project_name);
                
            //     $job =( new AllInInviteSsiProject2CreateMarkteingListJob($_project_name))->onQueue('api_ssi_invite_project_all_marketing_email_2');
            //     dispatch($job);
            // }
        }

    }

}
