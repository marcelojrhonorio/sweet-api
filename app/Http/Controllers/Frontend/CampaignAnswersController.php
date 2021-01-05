<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignAnswers;

class CampaignAnswersController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request)
    {
        $idCustomer = $request->input('customer')['id'] ?? $request->input('customer');
        $campaignAnswers = new CampaignAnswers();
        $campaignAnswers->answer = $request->input('answer');
        $campaignAnswers->campaigns_id = $request->input('campaign');
        $campaignAnswers->customers_id = $idCustomer;
        $campaignAnswers->save();

        $headerLocation = sprintf('%s/%d', $request->url(), $campaignAnswers->id);
        return response()->json([
            'status' => 'success',
            'result' => $campaignAnswers,
        ], 201, ['Location' => $headerLocation]);
    }

}