<?php

namespace App\Http\Controllers\Interests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Interests\CustomersInterest;

class CustomersInterestController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    
    public function __construct(CustomersInterest $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $interest_types_id = $request->input('interest_types_id');
        $interest = $request->input('interest');

        $customersInterest = new CustomersInterest;
        $customersInterest->customers_id = $customers_id;
        $customersInterest->interest_types_id = $interest_types_id;
        $customersInterest->interest = $interest;
        $customersInterest->save();

        return response()->json([
            'success' => true,
            'data'    => $customersInterest,    
        ]);

    }

    public function delete(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $interest_types_id = $request->input('interest_types_id');

        $customersInterest = CustomersInterest::where('customers_id', $customers_id)
                                              ->where('interest_types_id', $interest_types_id)
                                              ->first() ?? null;
        
        if($customersInterest) {
            $customersInterest->delete();
        }

        return response()->json([
            'success' => true,
            'data'    => [],    
        ]);

    }

}
