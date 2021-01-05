<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use Validator;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @todo Add docs.
 */
class ClickLoginController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->only(['email']), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status'  => 'unauthorized_login',
                'data'    => 'E-mail inválido',
            ], 422);
        }

        $email = $request->input('email');

        $customer = Customers::where('email', $email)->first();

        if (empty($customer)) {
            return response()->json([
                'success' => false,
                'status'  => 'unauthorized_login',
                'data'    => 'E-mail não encontrado',
            ]);
        }

        if (!$customer->changed_password) {
            return response()->json([
                'success' => false,
                'status'  => 'password_must_be_changed',
                'data'    => 'A senha deve ser alterada',
            ], 206);            
        }

        $token = base64_encode(str_random(40));

        $customer->token = $token;
        $customer->store_logins ++;
        $customer->last_store_login_at = Carbon::now()->toDateTimeString();
        $customer->save();

        return response()->json([
            'success' => true,
            'status'  => 'authorized_login',
            'data'    => [
                'id'        => $customer->id,
                'fullname'  => $customer->fullname,
                'email'     => $customer->email,
                'gender'    => $customer->gender,
                'birthdate' => $customer->birthdate,
                'cep'       => $customer->cep,
                'avatar'    => $customer->avatar,
                'points'    => $customer->points,
                'confirmed' => $customer->confirmed,
                'receive_offers' => $customer->receive_offers,
                'token'     => $token,
                'clicks_share_mail' => (int) $customer->clicks_share_mail,
            ],
        ], 200);
    }
}
