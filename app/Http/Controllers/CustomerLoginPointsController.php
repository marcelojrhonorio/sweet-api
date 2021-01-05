<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\CustomerLoginPoint;
use App\Http\Controllers\Controller;

class CustomerLoginPointsController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customers'];
    
    public function __construct(CustomerLoginPoint $model)
    {
        $this->model = $model;
    }

    public function verify(Request $request)
    {
        $customers_id = $request->input('customers_id');

        $customerLoginPoint = CustomerLoginPoint::where('customers_id', $customers_id)->first() ?? null;

        if($customerLoginPoint) {
            $aux = explode(' ', $customerLoginPoint->last_customer_login_points_at)[0];

            if($aux === Carbon::now()->toDateString()) {

                return response()->json([
                    'success' => false,
                    'data'  => [],
                ]);

            } else {

                $customerLoginPoint->total_logins = $customerLoginPoint->total_logins + 1;
                $customerLoginPoint->last_customer_login_points_at = Carbon::now()->toDateString();
                $customerLoginPoint->update();

                $points = self::updateCustomerPoints($customers_id);

                return response()->json([
                    'success' => true,
                    'data'  => $points,
                ]);
            }

        } else {
            
            $customerLoginPoint = new CustomerLoginPoint();
            $customerLoginPoint->customers_id = $customers_id;
            $customerLoginPoint->total_logins = 1;
            $customerLoginPoint->last_customer_login_points_at = Carbon::now()->toDateString();
            $customerLoginPoint->save();

            $points = self::updateCustomerPoints($customers_id);

            return response()->json([
                'success' => true,
                'data'  => $points,
            ]);
        }

    }

    private static function updateCustomerPoints($customers_id)
    {
        $customer = Customers::where('id', $customers_id)->first() ?? null;

        if($customer) {
            $customer->points = $customer->points + 20;
            $customer->update();
        }

        return $customer->points;
    }
}
