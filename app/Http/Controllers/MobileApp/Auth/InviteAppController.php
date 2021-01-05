<?php

namespace App\Http\Controllers\MobileApp\Auth;

use Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppWaitingList;
use App\Models\MobileApp\AppAllowedCustomer;

class InviteAppController extends Controller
{
    public function verfiyInviteApp(int $customerId)
    {
        $allowedCustomer = AppAllowedCustomer::where('customers_id', $customerId)->first() ?? null;        
       
        if (null !== $allowedCustomer || isset($allowedCustomer->id)) {
            return response()->json([
                'data' => 'app_user_allowed',
            ]);
        } 
        
        $allowedCustomers = AppAllowedCustomer::all();
        
        if(count($allowedCustomers) < env('APP_USERS'))
        {
            $access_expired_at = Carbon::createFromFormat("Y-m-d H:i:s", '2020-12-31 23:59:59');
                
            $allowed = new AppAllowedCustomer();
            $allowed->customers_id = $customerId;
            $allowed->access_expired_at = $access_expired_at;
            $allowed->save();

            return response()->json([
                'data' => 'app_user_download',
            ]); 

        } else {
            
            return response()->json([
                'data' => 'app_user_add_waiting_list',
            ]);
        }       
    }

    public function createWaitingList(int $customerId)
    {
        $appWaitingList = AppWaitingList::where('customers_id', $customerId)->first() ?? null;
            
        if(null !== $appWaitingList || isset($appWaitingList->id)){
            return response()->json([
                'success' => false,
                'data' => 'app_user_in_waiting_list',
            ]);
        }

        $waitingList = new AppWaitingList();
        $waitingList->customers_id = $customerId;
        $waitingList->save();

        return response()->json([
            'success' => true,
            'data' => $waitingList,
        ]);
    }
}
