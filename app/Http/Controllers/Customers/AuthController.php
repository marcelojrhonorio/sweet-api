<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use Log;
use Validator;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

/**
 * @todo Add docs.
 */
class AuthController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function login(Request $request)
    {        
        $validator = Validator::make($request->only(['email', 'password']), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'data'    => [],
            ], 422);
        }

        $customer = Customers::where('email', $request->input('email'))->first();

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors' => ['not_found'],
                'data' => [],
            ], 404);
        }       

        $passwordMatches          = Hash::check($request->input('password'), $customer->password);
        $secondaryPasswordMatches = Hash::check($request->input('password'), $customer->secondary_password);

        if(env('CHANGE_PASS')) {
            if(self::formatBirthdate($request->input('password')) === $customer->birthdate) {
                $passwordMatches = true;
            } else {
                $passwordMatches = false;
            }
        }

        if (false === ($passwordMatches || $secondaryPasswordMatches)) {
            return response()->json([
                'success' => false,
                'errors' => [],
                'data' => [],
            ], 401);
        }

        $token = base64_encode(str_random(40));

        Customers::where('email', $request->input('email'))->update(['token' => $token]);
        
        $customer->store_logins ++;
        $customer->last_store_login_at = Carbon::now()->toDateTimeString();
        $customer->save();

        return response()->json([
            'success' => true,
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
                'receive_offers'           => $customer->receive_offers,
                'indicated_by'             => $customer->indicated_by,
                'token'                    => $token,
                'clicks_share_mail'        => $customer->clicks_share_mail,
                'campaign_answerswered_at' => $customer->campaign_answers_at,
                'created_at'               => $customer->created_at,  
                'state'                    => $customer->state, 
                'updated_personal_info_at' => $customer->updated_personal_info_at,
                'ddd' => $customer->ddd,
                'phone_number' => $customer->phone_number,
            ],
        ], 200);
    }

    private static function formatBirthdate($birthdate)
    {
        $bday = explode("/", $birthdate);
        return ($bday[2] . '-' . $bday[1] . '-' . $bday[0]);
    }

    /**
     * @todo Add docs.
     */
    public function verify(Request $request, $code)
    {
        $customer = Customers::where('confirmation_code', '=', $code)->first();

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'error'   => 'Invalid confirmation code.',
            ]);
        }

        $customer->token = sha1(base64_encode(str_random(70)));
        $customer->confirmation_code = null;
        $customer->save();

        return response()->json([
            'success' => true,
            'data'    => $customer,
        ]);
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

    /**
     * @todo Add docs.
     */
    public function logout(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'token']), [
            'email' => 'required|email',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'data' => [],
            ], 422);
        }

        $customer = Customers::where('email', $request->input('email'))->first();

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors' => [],
                'data' => [],
            ], 404);
        }

        $tokenMatches = $request->input('token') === $customer->token;

        if (false === $tokenMatches) {
            return response()->json([
                'success' => false,
                'errors' => ['Token inválido.'],
                'data' => [],
            ], 401);
        }

        Customers::where('email', $request->input('email'))->update(['token' => null]);

        return response()->json([
            'success' => true,
            'data' => [],
        ], 200);
    }
}
