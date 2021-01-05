<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignTypes;

class CampaignTypesController extends Controller
{

    public function __construct()
    {
    }

    /*public function validate(Request $request)
    {
        return Validator::make($request->all(), [

        ]);
    }*/
    //http://www.vedovelli.com.br/web-development/laravel-5-middleware/
    //http://cafenaveia.blog.br/lumen-um-simples-tutorial-sobre-o-microframework-php-em-laravel/
    //https://magazine.softerize.com.br/tutoriais/php/laravel/relacionamento-entre-tabelas-laravel
    public function index()
    {
        $campaignTypes = CampaignTypes::all();

        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $campaignTypes,
        ], 200);
    }

    public function status($status)
    {
        $campaignTypes = CampaignTypes::where('status', '=', $status)->orderByDesc('id')->get();

        if (is_null($campaignTypes)) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $campaignTypes,
        ], 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show(int $id) : \Illuminate\Http\JsonResponse
    {
        $campaignTypes  = CampaignTypes::findOrFail($id);
        if (is_null($campaignTypes)) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json(['result' => $company], 200);
    }

    public function store(Request $request)
    {
        $campaignTypes = new CampaignTypes();
        $campaignTypes->fill($request->all());
        $campaignTypes->save();

        $headerLocation = sprintf('%s/%d', $request->url(), $campaignTypes->id);
        return response()->json([
            'status' => 'success',
            'result' => $campaignTypes,
        ], 201, ['Location' => $headerLocation]);

        return response()->json($campaignTypes, 201);
    }


    public function update(Request $request, $id)
    {
        //try {
        $campaignType = CampaignTypes::findOrFail($id);

        if (!$campaignType) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $campaignType->fill($request->all());
        $campaignType->save();

        return response()->json([
            'status' => 'success',
            'result' => $campaignType,
        ], 200);
        //} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //    response()->json($e);
       // }
    }

    public function destroy($id)
    {
        $campaignType = CampaignTypes::findOrFail($id);

        if(!$campaignType) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $campaignType->delete();
        return response()->json('', 204, ['entity' => $id]);
    }

}