<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateCustomerByCepJob1;

class UpdateCustomerByCep extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:update-by-cep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update customer informations by CEP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $job = (new UpdateCustomerByCepJob1())->onQueue('verify_customer_by_cep_1');
        dispatch($job);
    }
}
