<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use Validator;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerPasswordReset;

/**
 * @todo Add docs.
 */
class ForgotPasswordController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function email(Request $request)
    {
        $validator = Validator::make($request->only(['email']), [
            'email' => 'required|email',
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

        $reset = CustomerPasswordReset::firstOrNew(
            ['email' => $customer->email]
        );

        $reset->token = str_random(30);

        $reset->save();

        if (is_null($reset)) {
            return response()->json([
                'success' => false,
                'errors' => ['Cannot create reset password token.'],
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'email' => $reset->email,
                'token' => $reset->token,
            ],
        ], 200);
    }
}
