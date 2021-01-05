<?php

namespace App\Jobs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\BrazilCep;
use App\Models\Customers;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class PatchStateCityJob extends Job
{
    protected $customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => env('APP_URL'),
            'headers'  => [
                'cache-control' => 'no-cache',
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
            ],
        ]);


        $customer = Customers::find($this->customer->id);

        $customer->patch_cep_at = Carbon::now()->subDays(7)->toDateTimeString();

        $cep = $this->stripMask($this->customer->cep);

        $region = BrazilCep::where('cep', $cep)->first();

        if (empty($region)) {
            $viaCepData = $this->searchViaCepApi($cep);

            if (false === $viaCepData) {
                $customer->save();

                return;
            }

            $region = BrazilCep::create([
                'cep'    => $cep,
                'estado' => $viaCepData->uf,
                'cidade' => $viaCepData->localidade,
            ]);
        }

        $customer->state = $region->estado;
        $customer->city  = $region->cidade;

        $customer->save();
    }

    private function stripMask($cep) {
        $cleanCep = preg_replace('/\./', '', $cep);
        $cleanCep = preg_replace('/-/', '', $cleanCep);

        return $cleanCep;
    }

    private function searchViaCepApi($cep)
    {
        try {
            $client = new Client([
                'base_uri' => 'https://viacep.com.br/ws/',
                'headers'  => [
                    'cache-control' => 'no-cache',
                    'accept'        => 'application/json',
                    'content-type'  => 'application/json',
                ],
            ]);

            $response = $client->get($cep . '/json/');
            $json     = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if (isset($json->erro)) {
                Log::debug('CEP não encontrado! Número do CEP: ' . $cep . '.');

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
