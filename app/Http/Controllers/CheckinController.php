<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Checkin;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CheckinController extends Controller
{
    private $rules = [
        'customer_id' => 'required|numeric',
        'action_id'   => 'required|numeric',
    ];

    public function store(Request $request)
    {
        $data = $request->only([
            'customer_id',
            'action_id',
        ]);

        $validation = \Validator::make($data, $this->rules);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validation->errors(),
            ]);
        }

        $action = Action::find($request->input('action_id'));

        if (is_null($action)) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'not_found' => 'Request to invalid Action.',
                ],
            ]);
        }

        $customer = Customers::find($request->input('customer_id'));

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'not_found' => 'Request to invalid Customer.',
                ],
            ]);
        }

        $checkinVerify = Checkin::where('actions_id', $request->input('action_id'))
                          ->where('customers_id', $request->input('customer_id'))->first();

        if (!is_null($checkinVerify)) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'already_exists' => 'already exists a check in to this customer.',
                ],
            ]);
        }

        $checkin               = new Checkin();
        $checkin->customers_id = $request->input('customer_id');
        $checkin->actions_id   = $request->input('action_id');
        $checkin->points       = $action->grant_points;

        $checkin->save();

        $customer->points = $customer->points + $action->grant_points;

        $customer->save();

        return response()->json([
            'success' => true,
            'data'    => $customer,
        ]);
    }

    public function getCheckin(Request $request)
    {
       $checkinVerify = Checkin::where('actions_id', $request->query('action_id'))
                               ->where('customers_id', $request->query('customer_id'))->first();

        if (is_null($checkinVerify)) {
            return response()->json([
                'success' => false,
                'data'  => [],                
            ]);
        }

        return response()->json([
            'success' => true,
            'data'  => $checkinVerify,
        ]);
    }
}
