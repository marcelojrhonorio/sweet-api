<?php

namespace App\Console\Commands;

use Log;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class AllInTestToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allin:test-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test AllIn Token';

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

        $attempt = 20;

        while ($attempt > 0) {
            
            $client = new Client(['base_uri' => 'https://painel02.allinmail.com.br/allinapi']);

            $params = [
                'method' => 'get_token',
                'output' => 'json',
                'username' => env('ALLIN_MARKETING_USER','sweetbonus_allinapi'),
                'password' => env('ALLIN_MARKETING_PASS', 'CE7Y6U2E'),
            ];
        
            $query = urldecode(http_build_query($params));
        
            $response = $client->get('?' . $query);
        
            $json = json_decode($response->getBody()->getContents());
        
            $token = $json->token ?? null;
    
            Log::debug('[SSI] teste de token -> ' . $token);

            $attempt = $attempt - 1;
        } 

    }
}
