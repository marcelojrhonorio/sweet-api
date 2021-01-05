<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignsClickout;
use App\Repositories\ResourcesCampaignsRepository as ResourcesCampaigns;

class CampaignsClickoutController extends Controller
{

    public function index()
    {

    }

    public function store(Request $request)
    {
       /* $validator = \Validator::make($request->all(), $this->rules/*, $messages* /);

        if ($validator->fails()) {
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }*/

       if (is_array($request->get('answer')) && is_array($request->input('affirmative')) && is_array($request->input('link'))) {

           $resultArray = [];

           foreach ($request->get('answer') as $key => $value) {

               $entity = new CampaignsClickout();
               $entity->answer = $value;
               $entity->affirmative = $request->input('affirmative')[$key];
               $entity->link = $request->input('link')[$key];
               $entity->campaigns_id = $request->input('campaigns_id');
               $entity->save();

               $resultArray[] = $entity;
           }

           return response()->json([
               'status' => 'success',
               'result' => $resultArray,
           ], 201);

       } else {
           $entity = new CampaignsClickout();
           $entity->answer = $request->input('answer');
           $entity->affirmative = $request->input('affirmative');
           $entity->link = $request->input('link');
           $entity->campaigns_id = $request->input('campaigns_id');
           $entity->save();

           $headerLocation = sprintf('%s/%d', $request->url(), $entity->id);
           return response()->json([
               'status' => 'success',
               'result' => $entity,
           ], 201, ['Location' => $headerLocation]);
       }
    }

    public function update(Request $request, $id)
    {
        $campaignsClickout = CampaignsClickout::findOrFail($id);

        if(!$campaignsClickout) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $campaignsClickout->answer = $request->input('answer');
        $campaignsClickout->affirmative = $request->input('affirmative');
        $campaignsClickout->link = $request->input('link');
        $campaignsClickout->save();

        return response()->json([
            'status' => 'success',
            'result' => $campaignsClickout,
        ], 200);
    }

    public function destroy($id)
    {
        $campaignsClickout = CampaignsClickout::findOrFail($id);

        if(!$campaignsClickout) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $campaignsClickout->delete();

        return response()->json('', 204, ['entity' => $id]);
    }

    public function patch(Request $request, int $id)
    {
    }
}