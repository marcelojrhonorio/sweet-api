<?php

namespace App\Services\Util\AllIn;

use GuzzleHttp\Client;

class AllInClientGuzzleUtil
{
    /**
     *  Return a new guzzle client to send email!
     * */
    public static function getClient(string $uri = null)
    {
        return new Client(['base_uri' => $uri]);
    }
}
