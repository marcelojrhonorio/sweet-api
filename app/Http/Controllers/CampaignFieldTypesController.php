<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignFieldType;

class CampaignFieldTypesController extends Controller
{
    public function store(Request $request)
    {
        $campaignFieldType = new CampaignFieldType();
        $campaignFieldType->name = $request->input('name');
        $campaignFieldType->slug = $request->input('slug');

        $campaignFieldType->save();

        return response()->json([
            'status'   => 'success',
            'result'   => $campaignFieldType,
        ], 201);        

    }

    public function show($id)
    {
        $campaignFieldType = CampaignFieldType::find($id);

        if(empty($campaignFieldType)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field Type.'],
                'data'    => [],
            ], 404);            
        }

        return response()->json([
            'success' => true,
            'data'    => $campaignFieldType,
        ], 200);        

    }

    public function edit(Request $request, $id)
    {
        $campaignFieldType = CampaignFieldType::find($id);

        if(empty($campaignFieldType)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field Type.'],
                'data'    => [],
            ], 404);            
        }
        
        $campaignFieldType->name = $request->input('name');
        $campaignFieldType->slug = $request->input('slug');
        $campaignFieldType->save();

        return response()->json([
            'status'   => 'success',
            'result'   => $campaignFieldType,
        ], 200);          

    }

    public function destroy($id)
    {
        $campaignFieldType = CampaignFieldType::find($id);

        if(empty($campaignFieldType)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field Type.'],
                'data'    => [],
            ], 404);            
        }

        $campaignFieldType->delete();

        return response()->json([
            'status'   => 'success',
        ], 200);         

    }

}
