<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Jobs\PatchStateCityJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

/**
 * @todo Add docs.
 */
class PatchCityAndStateController extends Controller
{
    /**
     * @todo Add docs.
     */
    private $client;

    /**
     * @todo Add docs.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('APP_URL'),
            'headers'  => [
                'cache-control' => 'no-cache',
                'accept'        => 'application/json',
                'content-type'  => 'application/json',
            ],
        ]);
    }

    /**
     * @todo Add docs.
     */
    public function apply()
    {
        $customers = Customers::whereNull('state')
                        ->orWhere('state', '')
                        ->orWhere('city', '')
                        ->orWhereNull('city')
                        ->orWhere('city', 'Default')
                        ->where(function ($query) {
                            $oneWeekAgo = Carbon::now()->subDays(7)->toDateTimeString();

                            $query
                                ->whereNull('patch_cep_at')
                                ->orWhere('patch_cep_at', '<=', $oneWeekAgo);
                        })
                        ->get();

        Log::debug('Total de CEPs para processar: ' . count($customers->toArray()));

        $results = 0;

        foreach ($customers as $customer) {
            if (empty($customer->cep) || 10 !== strlen($customer->cep)) {
                Log::debug('Pulando CEP: ' . $customer->cep ?? 'Vazio');

                continue;
            }

            $patchJob = new PatchStateCityJob($customer);

            dispatch($patchJob->onQueue('patch_state_city'));

            Log::debug('Job disparado para o CEP: ' . $customer->cep);

            $results++;
        }

        return response()->json([
            'success' => true,
            'data'    => $results,
        ]);
    }
}
