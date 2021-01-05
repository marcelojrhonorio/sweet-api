<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

Use Log;
use Validator;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerPasswordReset;

/**
 * @todo Add docs.
 */
class ChangePasswordController extends Controller
{

    public function change(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'                 => 'required|email',
            'actual_password'       => 'required',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required'
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

        if(Hash::check($request->input('actual_password'), $customer->password) ||
           Hash::check($request->input('actual_password'), $customer->secondary_password)) {
            
            $customer->password = Hash::make($request->input('password'));
            $customer->changed_password = true;
            $customer->save();
    
            return response()->json([
                'success' => true,
                'data'    => $customer,
            ], 200);            
        }  

        return response()->json([
            'success' => false,
            'errors'  => ['Invalid actual password.'],
            'data'    => [],
        ], 406);       

    }

}
