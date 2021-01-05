<?php

namespace App\Http\Controllers\Customers;

Use Log;
use Validator;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerPasswordReset;

class CreatePasswordController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'                 => 'required|email',
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

        if (isset($customer->id) && $customer->changed_password) {
            return response()->json([
                'success' => false,
                'errors'  => 'operation not allowed',
                'data'    => [],
            ], 422);
        }

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors'  => ['Customer not found.'],
                'data'    => [],
            ], 404);
        }
        
        $customer->password = Hash::make($request->input('password'));
        Log::debug('Senha criada: ' . $request->input('password'));
        $customer->changed_password = true;
        $customer->save();

        return response()->json([
            'success' => true,
            'data'    => $customer,
        ], 200);        
    }
}
