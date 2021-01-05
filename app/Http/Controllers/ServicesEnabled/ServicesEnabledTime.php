<?php

namespace App\Http\Controllers\ServicesEnabled;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ServicesEnabledTime extends Controller
{
    public function smartlook(Request $request){

    $currentTime = Carbon::now();

    $timeNow = Carbon::createFromTime($currentTime->hour, $currentTime->minute, $currentTime->second, 'America/Sao_Paulo');

        $range1 = [Carbon::createFromTime(10, 00, 00, 'America/Sao_Paulo'),Carbon::createFromTime(10, 59, 59, 'America/Sao_Paulo')];
        $range2 = [Carbon::createFromTime(14, 00, 00, 'America/Sao_Paulo'),Carbon::createFromTime(14, 59, 59, 'America/Sao_Paulo')];
        $range3 = [Carbon::createFromTime(19, 30, 00, 'America/Sao_Paulo'),Carbon::createFromTime(20, 29, 59, 'America/Sao_Paulo')];
        //$range4 = [Carbon::createFromTime(00, 00, 00, 'America/Sao_Paulo'),Carbon::createFromTime(00, 59, 59, 'America/Sao_Paulo')];
        
        $condition1 = $timeNow >= $range1[0] && $timeNow <= $range1[1];
        $condition2 = $timeNow >= $range2[0] && $timeNow <= $range2[1]; 
        $condition3 = $timeNow >= $range3[0] && $timeNow <= $range3[1];
        //$condition4 = $timeNow >= $range4[0] && $timeNow <= $range4[1];

        //$verify = ($condition1 || $condition2 || $condition3 || $condition4);
        $verify = ($condition1 || $condition2 || $condition3);
        
        return response()->json([
            'success' => true,
            'data'    => $verify
        ]);

    }

}
