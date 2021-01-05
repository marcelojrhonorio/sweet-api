<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

Use Log;
use Validator;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerPasswordReset;

/**
 * @todo Add docs.
 */
class ResetPasswordController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->only([
            'token',
            'email',
            'password',
            'password_confirmation',
        ]), [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'data'    => [],
            ], 422);
        }

        $reset = CustomerPasswordReset::where('token', $request->input('token'))->first();

        if (is_null($reset)) {
            return response()->json([
                'success' => false,
                'errors' => ['Reset token not found.'],
                'data' => [],
            ], 404);
        }

        $reset->customer()->update(['password' => Hash::make($request->input('password'))]);

        return response()->json([
            'success' => true,
            'data'    => $reset->customer,
        ], 200);
    }

    public function update(Request $request)
    {
        $updatedPassword = false;

        $validator = Validator::make($request->all(), [
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
                'errors'  => ['Customer not found.'],
                'data'    => [],
            ], 404);
        }

        $passwordExpires = Carbon::parse($customer->last_password_request);
        $passwordExpires->addMinutes(5);

        if(Carbon::now() > $passwordExpires || 
           null === $customer->last_password_request) {
            $customer->update(['password' => Hash::make($request->input('password'))]);
            $customer->update(['last_password_request' => Carbon::now()]);
            $customer->update(['changed_password' => true]);
            $updatedPassword = true;
        }

        return response()->json([
            'success' => true,
            'data'    => ['customer' => $customer, 'updated'  => $updatedPassword],
        ], 200);
    }

}
