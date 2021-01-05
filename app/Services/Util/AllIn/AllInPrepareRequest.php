<?php

namespace App\Services\Util\AllIn;

class AllInPrepareRequest
{
    public static function prepareUrlQuery(array $params = [])
    {
        // Removing base_uri
        unset($params['base_uri']);

        if (empty($params)) {
            return [];
        }
        $urlParams = [
            'method' => $params['method'],
            'output' => $params['output'],

        ];

        if(array_key_exists('username', $params) && array_key_exists('password', $params)){
            $urlParams+=['username' => $params['username']];
            $urlParams+=['password' => $params['password']];
        }
        if(array_key_exists('token', $params)){
            unset($params['method']);
            unset($params['output']);
            $urlParams+=$params;
        }

        return urldecode(
            http_build_query($urlParams)
        );
    }
}
