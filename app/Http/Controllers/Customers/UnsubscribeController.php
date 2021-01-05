<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use App\Models\Customers;
use App\Models\Unsubscribed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @todo Add docs.
 */
class UnsubscribeController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function unsubscribe(Request $request)
    {
        $validation = Validator::make($request->only('email'), [
            'email' => 'required|email',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'data'    => 'E-mail inválido',
            ], 422);
        }

        $email = $request->query('email');

        $customer = Customers::where('email', $email)->first();

        if (empty($customer)) {
            return response()->json([
                'success' => false,
                'data'    => 'Usuário não encontrado',
            ], 422);
        }

        $optOut = Unsubscribed::create([
            'customer_id' => $customer->id,
        ]);

        if (empty($optOut)) {
            return response()->json([
                'success' => false,
                'data'    => 'Não foi possível cancelar a inscrição',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data'    => $optOut->customer,
        ]);
    }
}
