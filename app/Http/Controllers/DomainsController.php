<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domains;

/**
 * Class CompaniesController
 * @package App\Http\Controllers
 */
class DomainsController extends Controller
{

    private $rules =  [
        'name' => 'required|max:30',
        'link' => 'required|max:255',
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
        $domains = Domains::where('status', '=' ,1)->select('id', 'name', 'link' , 'status')->orderByDesc('id')->get();

        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $domains,
        ], 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function find(int $id) : \Illuminate\Http\JsonResponse
    {
        $domain  = Domains::findOrFail($id);
        if(!$domain) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json(['result' => $domain], 200);
    }
    /**
     * Create a new customer
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $domain = new Domains();
        $domain->name = $request->input('name');
        $domain->link = $request->input('link');
        $domain->status = ($request->exists('status') ? $request->input('status') : 1);
        $domain->user_id_created = $request->get('userid') ?? 1;
        $domain->save();

        $headerLocation = sprintf('%s/%d', $request->url(), $domain->id);
        return response()->json([
            'status' => 'success',
            'result' => $domain,
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
        $domain  = Domains::findOrFail($id);
        $domain->name = $request->input('name');
        $domain->link = $request->input('link');
        $domain->status = ($request->exists('status') ? $request->input('status') : 1);
        $domain->user_id_updated = $request->get('userid');
        $domain->save();

        return response()->json([
            'status' => 'success',
            'result' => $domain,
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
        $domain  = Domains::findOrFail($id);

        if(!$domain) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        foreach ($request->all() as $key => $value) {
            if ($key == 'userid') {
                continue;
            }
            $domain->{$key} = $value;
        }

        $domain->user_id_updated = $request->get('userid');
        $domain->save();
        return response()->json($domain, 200);
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
        $domain  = Domains::findOrFail($id);

        if(!$domain) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
        $domain->delete();

        return response()->json('', 204, ['entity' => $id]);
    }
}
