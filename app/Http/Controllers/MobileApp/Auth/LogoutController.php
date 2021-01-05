<?php

namespace App\Http\Controllers\MobileApp\Auth;

use Log;
use Validator;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
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
