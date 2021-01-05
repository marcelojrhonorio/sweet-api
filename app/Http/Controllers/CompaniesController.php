<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies;

/**
 * Class CompaniesController
 * @package App\Http\Controllers
 */
class CompaniesController extends Controller
{

    private $rules =  [
        'name' => 'required|max:80',
        'cnpj' => 'unique:companies,cnpj|required|max:14',
        'nickname' => 'required|max:50',
    ];

    /*private $messages = [
        'required' => 'Custom message',
        'numeric'  => 'Custom message'
    ];*/
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Get all customers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //$companies  = Companies::all();
        $companies = Companies::where('status', '=' ,1)->orderByDesc('id')->get();

        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $companies,
        ], 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function find(int $id) : \Illuminate\Http\JsonResponse
    {
        //$companies  = Companies::find($id);
        $company  = Companies::findOrFail($id);
        if (is_null($company)) {
            throw new \Exception('Company not found.');
        }

        return response()->json(['result' => $company], 200);
    }
    /**
     * Create a new customer
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->rules/*, $messages*/);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $company = new Companies();
        $company->name = $request->input('name');
        $company->cnpj = $request->input('cnpj');
        $company->nickname = $request->input('nickname');
        $company->status = ($request->exists('status') ? $request->input('status') : 1);
        $company->user_id_created = $request->get('userid') ?? 1;
        $company->save();

        $headerLocation = sprintf('%s/%d', $request->url(), $company->id);
        return response()->json([
            'status' => 'success',
            'result' => $company,
        ], 201, ['Location' => $headerLocation]);
    }

    /**
     * Update the specified company.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $company  = Companies::findOrFail($id);
        $company->name = $request->input('name');
        $company->cnpj = $request->input('cnpj');
        $company->nickname = $request->input('nickname');
        $company->status = ($request->exists('status') ? $request->input('status') : 1);
        $company->user_id_updated = $request->get('userid');
        $company->save();

        return response()->json([
            'status' => 'success',
            'result' => $company,
        ], 200);
    }

    /**
     * Update partial fields the specified company
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function patch(Request $request, int $id)
    {
        $fields = [];
        $company  = Companies::findOrFail($id);

        if (is_null($company)) {
            throw new \Exception('Company not found.');
        }

        foreach ($request->all() as $key => $value) {
            if ($key == 'userid') {
                continue;
            }
            $company->{$key} = $value;
        }

        //dd($fields);
        //$company->update($fields);
        $company->user_id_updated = $request->get('userid');
        $company->save();
        return response()->json($company, 200);
    }

    /**
     * Delete the specified customer
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $company  = Companies::findOrFail($id);

        if (is_null($company)) {
            throw new \Exception('Company not found.');
        }
        $company->delete();

        return response()->json('', 204, ['entity' => $id]);
    }
}
