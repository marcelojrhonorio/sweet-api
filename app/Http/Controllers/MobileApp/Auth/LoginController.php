<?php

namespace App\Http\Controllers\MobileApp\Auth;

use Log;
use Validator;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppAllowedCustomer;

class LoginController extends Controller
{
    public function login(Request $request)
    {        
        $validator = Validator::make($request->only(['email', 'password', 'onesignal_id']), [
            'email'    => 'required|email',
            'password' => 'required',
            'onesignal_id' => 'required',
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

        /**
         * Se não tiver o allowed_customer é criada a 
         * instância e libera o acesso ao app.
         */
        if(false === $allowedCustomer){
            $access_expired_at = Carbon::createFromFormat("Y-m-d H:i:s", '2020-12-31 23:59:59');

            $allowed = new AppAllowedCustomer();
            $allowed->customers_id = $customer->id;
            $allowed->access_expired_at = $access_expired_at;
            $allowed->save();
        }

        self::updateOneSignalId($customer->id, $request->input('onesignal_id'));

        $passwordMatches          = Hash::check($request->input('password'), $customer->password);
        $secondaryPasswordMatches = Hash::check($request->input('password'), $customer->secondary_password);

        if (false === ($passwordMatches || $secondaryPasswordMatches)) {
            return response()->json([
                'success' => false,
                'status'  => 'invalid_password',
                'errors' => [],
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

    private static function updateOneSignalId(int $customer_id, $onesignal_id)
    {
       $customer = Customers::find($customer_id);

       if((null === $customer->onesignal_id) || ($customer->onesignal_id !== $onesignal_id)) {
           $customer->onesignal_id = $onesignal_id;
           $customer->save();
       }

    }

    public function renewToken(Request $request, $customerId)
    {
        $customer = Customers::find($customerId);
        
        if(is_null($customer->token)){
            $customer->token = sha1(base64_encode(str_random(70)));
            $customer->save();
        }

        return response()->json([
            'success' => true,
            'data'    => $customer->token,
        ]);        
    }
}
