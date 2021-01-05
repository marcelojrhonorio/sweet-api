<?php

namespace App\Http\Controllers\XMoveCar;

use Log;
use Illuminate\Http\Request;
use App\Models\XMoveCar\XMoveCar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class XMoveCarController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;

    public function __construct(XMoveCar $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:60',
            'email'       => 'email|required|max:40',
            'cell_phone'  => 'required|max:14',
            'phone'       => 'nullable|max:14',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $xMoveCar = XMoveCar::where('email', $request->input('email'))->first();

        if (!is_null($xMoveCar)){
            return response()->json([
                'status'   => 'email_exists',
                'data'   => [],
            ], 201);            
        }

        $xMoveCar             = new XMoveCar();
        $xMoveCar->name       = $request->input('name');
        $xMoveCar->email      = $request->input('email');
        $xMoveCar->cell_phone = $request->input('cell_phone');
        $xMoveCar->phone      = $request->input('phone');
        $xMoveCar->save();

        return response()->json([
            'status'   => 'success',
            'data'   => $xMoveCar,
        ], 201);
    }
}
