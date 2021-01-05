<?php

namespace App\Jobs;

use App\Services\AllInMarketingService;
use Illuminate\Support\Facades\Log;

class AllInInviteSsiProject3DispatchEmailsJob extends Job
{
    protected $campaing_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $campaing_id = null)
    {
        //
        $this->campaing_id = $campaing_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $responseEmailTest = AllInMarketingService::emailTestDispatch($this->campaing_id);
        Log::info($responseEmailTest);
        $responseEmailDispactch = AllInMarketingService::emailDispatch($this->campaing_id);
        Log::info($responseEmailDispactch);
    }
}
