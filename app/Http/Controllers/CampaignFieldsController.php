<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignField;

class CampaignFieldController extends Controller
{
    public function store(Request $request)
    {
        $campaignField = new CampaignField();
        $campaignField->label = $request->input('label');
        $campaignField->campaign_field_type_id = $request->input('campaign_field_type_id');
        $campaignField->campaign_id = $request->input('campaign_id');

        $campaignField->save();

        return response()->json([
            'status'   => 'success',
            'result'   => $campaignField,
        ], 201);         

    }

    public function show($id)
    {
        $campaignField = CampaignField::find($id);

        if(empty($campaignField)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field.'],
                'data'    => [],
            ], 404);            
        }

        return response()->json([
            'success' => true,
            'data'    => $campaignField,        
        ], 200);

    }

    public function edit(Request $request, $id)
    {
        $campaignField = CampaignField::find($id);

        if(empty($campaignField)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field.'],
                'data'    => [],
            ], 404);            
        }

        $campaignField->label = $request->input('label');
        $campaignField->campaign_field_type_id = $request->input('campaign_field_type_id');
        $campaignField->save();
        
        return response()->json([
            'success' => true,
            'data'    => $campaignField,        
        ], 200);
    }

    public function destroy($id)
    {
        $campaignField = CampaignField::find($id);

        if(empty($campaignField)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field.'],
                'data'    => [],
            ], 404);            
        }

        $campaignField->delete();

        return response()->json([
            'success' => true,       
        ], 200);        
    }

}
