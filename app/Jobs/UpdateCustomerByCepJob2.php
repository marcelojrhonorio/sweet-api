<?php

namespace App\Jobs;

use Log;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\ClientException;
use App\Models\CustomerRegisterDivergence;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class UpdateCustomerByCepJob2 extends Job
{
    
    private $timeout = 300;

    private $id, $cep;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $cep)
    {
        $this->id  = $id;
        $this->cep = $cep;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cleanCep = preg_replace("/\D+/", "", $this->cep);
        
        $customer = Customers::find($this->id);

        if (!isset($customer->id)) {
            return;
        }
        
        $data = self::callPricezApi($cleanCep);

        if (isset($data->payload->ddd)) {
            $ddd   = $data->payload->ddd;
            $state = $data->payload->estado;
            $city  = $data->payload->cidade;

            if ($customer->ddd !== $ddd) {
                $customer->ddd = $ddd;
            }

            if ($customer->state !== $state) {
                $customer->state = $state;
            }

            if ($customer->city !== $city) {
                $customer->city = $city;
            }

            $customer->updated_by_cep = 1;
            $customer->updated_by_cep_at = Carbon::now()->toDateTimeString();
            $customer->save();

        } else {

            $customer->invalid_cep = 1;
            $customer->updated_by_cep = 1;
            $customer->updated_by_cep_at = Carbon::now()->toDateTimeString();
            $customer->save();

        }
    }

    private static function callPricezApi ($cep) {
        try {
            
            $client = new Client([
                'base_uri' => 'http://ddd.pricez.com.br/cep/',
                'headers'  => [
                    'cache-control' => 'no-cache',
                    'accept'        => 'application/json',
                    'content-type'  => 'application/json',
                ],
            ]);

            $response = $client->get($cep . '.json');
            $json     = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if (!isset($json->payload->cidade)) {
                return false;
            }

            return $json;            

        } catch (RequestException $exception) {
            Log::debug($exception->getMessage());
        } catch (ConnectException $exception) {
            Log::debug($exception->getMessage());
        } catch (ClientException $exception) {
            Log::debug($exception->getMessage());
        }
    }
}
