<?php

namespace App\Traits;

use App\Models\Customers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

trait CalogaLeadTrait
{
    public function dispatchLead(Customers $customer = null)
    {
        if (!empty($customer)) {
            $this->pixelCalogaUrl = 'http://sweet.go2cloud.org/aff_lsr?offer_id=35&aff_id=1010';
            $this->clientCaloga = new Client(
                [
                    'http_errors' => false,
                    'headers' => [
                        'cache-control' => 'no-cache',
                    ],
                ]
            );
            $splitedName = $this->splitName($customer->fullname);
            $lead = [
                'gender' => $customer->gender === 'M' ? 'H' : 'F',
                'firstname' => urlencode($splitedName[0]),
                'lastname' => urlencode($splitedName[1]),
                'email' => $customer->email,
                'birthdate' => $customer->birthdate,
                'pc' => preg_replace('/\./', '', $customer->cep),
                'ip' => $customer->ip_address,
                'registerdate' => urlencode($customer->created_at),
                'source' => 'produtos',
            ];

            $url = env('API_CALOGA') . '?gender=' . $lead['gender'] . '&firstname=' . $lead['firstname'] . '&lastname=' . $lead['lastname'] . '&email=' . $lead['email'] . '&birthdate=' . $lead['birthdate'] . '&pc=' . $lead['pc'] . '&ip=' . $lead['ip'] . '&registerdate=' . $lead['registerdate'] . '&source=' . $lead['source'];
            $response = $this->clientCaloga->get($url);
            $body = (string) $response->getBody();
            $customer->caloga_api_return = $body;
            $customer->update();

            if ('OK' === $body) {
                // $responsePixel = $this->clientCaloga->get($this->pixelCalogaUrl);
                // $bodyPixel = (string) $responsePixel->getBody();
                return true;
            }
            Log::debug("Error ao enviar dados para a API do Caloga, retorno do caloga -> {$body}");
        }
        return false;
    }
    /**
     * @todo Add docs.
     */
    private function splitName($fullname)
    {
        $names = explode(' ', $fullname);
        $firstname = $names[0];
        unset($names[0]);
        $lastname = join(' ', $names);
        return [$firstname, $lastname];
    }
}
