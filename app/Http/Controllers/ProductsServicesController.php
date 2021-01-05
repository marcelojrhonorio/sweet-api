<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductServiceStamp\ProductServiceStamp;
use App\Repositories\ResourcesProductsServicesRepository as Resources;

/**
 * Class CompaniesController
 * @package App\Http\Controllers
 */
class ProductsServicesController extends Controller
{

    private $rules =  [
        'title' => 'required|max:150',
        'description' => 'required|max:255',
        'image' => 'required|max:255',
        'points' => 'required|integer',
    ];

    private $resources;

    public function __construct()
    {
        $this->resources = new Resources();
    }

    /**
     * Get all customers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entity = ProductsServices::where('status', '=' ,1)->select('id', 'title', 'description' , 'path_image', 'points', 'status', 'category_id as category')->orderByDesc('id')->get();
               
        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $entity,
        ], 200);
    }

    public function getById($id)
    {
        $entity = ProductsServices::find($id);

        if (empty($entity))
        {
            return response()->json([
                'results' => [],
            ], 200);            
        }

        return response()->json([
            'results' => $entity,
        ], 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
   /* public function find(int $id) : \Illuminate\Http\JsonResponse
    {
        $domain  = Domains::findOrFail($id);
        if(!$domain) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json(['result' => $domain], 200);
    }*/
    /**
     * Create
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

        $entity = new ProductsServices();
        $entity->title = $request->input('title');
        $entity->description = $request->input('description');
        $entity->points = $request->input('points');
        $entity->path_image = $request->input('image');
        $entity->status = ($request->exists('status') ? $request->input('status') : 1);
        $entity->category_id = $request->input('category');
        $entity->user_id_created = $request->get('userid');
        $entity->user_id_updated = $request->get('userid');
        $entity->social_network = $request->get('social_network') ?? null;
        $entity->exibition_time = $request->get('exibition_time') ?? null;
        $entity->save();

        $headerLocation = sprintf('%s/%d', $request->url(), $entity->id);
        return response()->json([
            'status' => 'success',
            'result' => $entity,
        ], 201, ['Location' => $headerLocation]);
    }

    public function resources()
    {

        $categories = [];

        try {

            //CampaignTypes
            $categories = $this->resources->findCategories();

            return response()->json([
                /*'metadata' => [
                    'resultset' => [
                        'count' => 0,
                        'offset' => 0,
                        'limit' => 10
                    ],
                ],*/
                'results' => [
                    'categories' => $categories,
                ],
            ], 200);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
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
        $entity  = ProductsServices::findOrFail($id);
        $entity->title = $request->input('title');
        $entity->description = $request->input('description');
        $entity->points = $request->input('points');
        $entity->path_image = $request->input('image');
        $entity->status = ($request->exists('status') ? $request->input('status') : 1);
        $entity->category_id = $request->input('category');
        $entity->user_id_updated = $request->get('userid');
        $entity->social_network = $request->get('social_network') ?? null;
        $entity->exibition_time = $request->get('exibition_time') ?? null;        
        
        $entity->save();

        return response()->json([
            'status' => 'success',
            'result' => $entity,
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
        $entity  = ProductsServices::findOrFail($id);

        if(!$entity) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        foreach ($request->all() as $key => $value) {
            if ($key == 'userid') {
                continue;
            }
            $entity->{$key} = $value;
        }

        $entity->user_id_updated = $request->get('userid');
        $entity->save();
        return response()->json($entity, 200);
    }

    /**
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $entity  = ProductsServices::findOrFail($id);

        if(!$entity) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
        $entity->delete();

        return response()->json([
            'success' => true
        ], 200);

        //return response()->json('', 204, ['entity' => $id]);
       
    }
}
