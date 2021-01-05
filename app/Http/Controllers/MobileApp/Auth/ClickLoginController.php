<?php

namespace App\Http\Controllers\MobileApp\Auth;

use Log;
use Validator;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppAllowedCustomer;

class ClickLoginController extends Controller
{
    public function clickLogin(Request $request)
    {        
        $validator = Validator::make($request->only(['email']), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'status' => 'invalid_data',
                'data'    => [],
            ], 422);
        }

        $customer = Customers::where('email', $request->input('email'))->first();

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors' => ['not_found'],
                'status' => 'customer_not_found',
                'data' => [],
            ], 404);
        }

        $allowedCustomer = self::verifyIsAllowedCustomer($customer->id);

        if(false === $allowedCustomer){
            return response()->json([
                'success' => false,
                'errors' => [],
                'status' => 'not_allowed_customer',
                'data' => [],
            ], 401);
        }

        $token = base64_encode(str_random(40));

        Customers::where('email', $request->input('email'))->update(['token' => $token]);
        
        $customer->app_logins ++;
        $customer->save();        

        return response()->json([
            'success' => true,
            'status'  => 'success',
            'data' => [
                'id'                       => $customer->id,
                'name'                     => $customer->fullname,
                'email'                    => $customer->email,
                'gender'                   => $customer->gender,
                'birthdate'                => $customer->birthdate,
                'cep'                      => $customer->cep,
                'avatar'                   => $customer->avatar,
                'points'                   => $customer->points,
                'confirmed'                => $customer->confirmed,
                'indicated_by'             => $customer->indicated_by,
                'token'                    => $token,
                'clicks_share_mail'        => $customer->clicks_share_mail,
                'campaign_answerswered_at' => $customer->campaign_answers_at,
                'created_at'               => $customer->created_at,  
                'state'                    => $customer->state, 
                'updated_personal_info_at' => $customer->updated_personal_info_at,
                'ddd'                      => $customer->ddd,
                'phone_number'             => $customer->phone_number,
                'onesignal_id'             => $customer->onesignal_id,
            ],
        ], 200);
    }

    private static function verifyIsAllowedCustomer(int $customer_id)
    {
        $allowedCustomer = AppAllowedCustomer::where('customers_id', $customer_id)->first();

        $now = Carbon::now()->toDateTimeString();

        if(isset($allowedCustomer->id) && ($allowedCustomer->access_expired_at > $now)) {
            return true;
        } 

        return false;
    }

}
