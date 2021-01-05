<?php

namespace App\Http\Controllers;

use App\Models\Surveis;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveyPostbackController extends Controller
{
   private $rules = [
        'survey_id'     => 'required|numeric',
        'survey_type'   => 'required|string',
        'customer_id'   => 'required|numeric',
    ];

    public function store(Request $request)
    {
 
        $data = $request->only([
            'survey_id',
            'survey_type',
            'customer_id',
        ]);


        $validation = \Validator::make($data, $this->rules);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validation->errors(),
            ]);
        }
        
        $customer = Customers::find($request->customer_id);

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors'  => [
                    'not_found' => 'Request to invalid Customer.',
                ],
            ]);
        }

        $survey = new Surveis($data);
        $survey->save();


        return response()->json([
            'success' => true,
        ]);
    }
}
