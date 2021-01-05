<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @todo Add docs.
 */
class ProfileController extends Controller
{
    protected $rules = [
        'fullname'  => 'required',
        'gender'    => 'required|string|size:1',
        'birthdate' => 'required|date_format:d/m/Y',
        'cep'       => 'required|size:10|regex:/^\d{2}\.?\d{3}-\d{3}$/',
    ];

    public function update(Request $request, $customerId)
    {
        $customer = Customers::find($customerId);

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors'  => [],
                'data'    => [],
            ], 404);
        }

        $data = $request->only([
            'fullname',
            'gender',
            'birthdate',
            'cep',
        ]);

        $validation = \Validator::make($data, $this->rules);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validation->errors(),
                'data'    => [],
            ], 422);
        }

        $data['birthdate'] = implode('-', array_reverse(explode('/', $data['birthdate'])));

        $customer->fill($data);
        $customer->save();

        return response()->json([
            'success' => true,
            'data'    => $customer,
        ], 200);
    }
}
