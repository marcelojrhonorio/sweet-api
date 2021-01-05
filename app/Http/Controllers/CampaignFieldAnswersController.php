<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignFieldAnswer;

class CampaignFieldAnswersController extends Controller
{
    public function store(Request $request)
    {
        $campaignFieldAnswer = new CampaignFieldAnswer();
        $campaignFieldAnswer->campaign_answer_id = $request->input('campaign_answer_id');
        $campaignFieldAnswer->value = $request->input('value');
        $campaignFieldAnswer->campaign_field_id = $request->input('campaign_field_id');
        
        $campaignFieldAnswer->save();
        
    }

    public function show($id)
    {
        $campaignFieldAnswer = CampaignFieldAnswer::find($id);

        if(empty($campaignFieldAnswer)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Campaign Field Answer.'],
                'data'    => [],
            ], 404);  
        }

        return response()->json([
            'success' => true,
            'data'    => $campaignFieldAnswer,              
        ], 200);

    }

}
