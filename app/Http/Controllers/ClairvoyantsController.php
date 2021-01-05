<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Clairvoyants;
use Illuminate\Http\Request;
use App\Jobs\CustomerCreatedJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Datatables;

/**
 * @todo validar tag erro retorno json com códiog de erro 400
 * @todo erro 422 quando os dados não são processados
 *
 * Class CustomersController
 * @package App\Http\Controllers
 */
class ClairvoyantsController extends Controller
{

    public function index(Request $request)
    {
        $entity = Clairvoyants::select(
            'clairvoyants.*'
        );

        return response()->json([
            'results' => $entity->get(),
        ], 200);
    }


    /**
     * Create a new register in clairvoyant
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|max:60',
            'email_address' => 'email|required|max:40',
            'birthdate'     => 'required|date',
            'gender'        => 'required|max:1',
            'ddd_home'      => 'nullable|max:2',
            'phone_home'    => 'nullable|max:14',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $clairvoyant = Clairvoyants::where('email_address', $request->input('email_address'))->first();

        if (!is_null($clairvoyant)){
            return response()->json([
                'status'   => 'email_exists',
                'data'   => [],
            ], 201);            
        }

        $clairvoyant                 = new Clairvoyants();
        $clairvoyant->first_name     = $request->input('first_name');
        $clairvoyant->email_address  = $request->input('email_address');
        $clairvoyant->birthdate      = $request->input('birthdate');
        $clairvoyant->gender         = $request->input('gender');
        $clairvoyant->ddd_home       = $request->input('ddd_home');
        $clairvoyant->phone_home     = $request->input('phone_home');
        $clairvoyant->lead           = $request->input('lead');
        $clairvoyant->pixel          = $request->input('pixel');  
        $clairvoyant->save();

        return response()->json([
            'status'   => 'success',
            'data'   => $clairvoyant,
        ], 201);
    }
}
