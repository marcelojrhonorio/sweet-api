<?php

if (!function_exists('ageCalculate')) {

    function ageCalculate(string $birthDate) {

        $date = new \DateTime( $birthDate );
        $interval = $date->diff(new \DateTime());

        $arrayReturn = explode('|', $interval->format( '%Y|%m|%d'));
        return [
            'year' => $arrayReturn[0],
            'month' => $arrayReturn[1],
            'day' => $arrayReturn[2],
        ];

    }

}



