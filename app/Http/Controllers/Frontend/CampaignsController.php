<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaigns;
use App\Repositories\ResourcesCampaignsRepository as ResourcesCampaigns;

class CampaignsController extends Controller
{
    private $resources;

    public function __construct()
    {
        $this->resources = new ResourcesCampaigns();
    }

    public function index(Request $request)
    {
        $campaigns = Campaigns::with([
                'clickout',
                'domains',
                'types'
            ])->where([
            'status' => $request->get('status'),
            'desktop' => $request->get('desktop'),
            ])
            ->whereHas('domains', function ($query) use ($request) {
                $query->where('domains.name', $request->get('domainName'));
            })
            ->select('campaigns.id',
                'campaigns.name',
                'campaigns.title',
                'campaigns.question',
                'campaigns.path_image as image',
                'campaigns.postback_url',
                'campaigns.id_has_offers',
                'campaigns.companies_id',
                'campaigns.campaign_types_id',
                'campaigns.order'
            )
            ->orderBy('campaigns.order','ASC')
            //->orderBy('campaigns.id','ASC')
            ->get();

            //->toSql();
            //->getBindings();


        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $campaigns,
        ], 200);
    }

    /**
     * Update partial fields the specified Campaign
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function patch(int $id)
    {
        try {
            $campaign = Campaigns::findOrFail($id);

            if (is_null($campaign)) {
                throw new \Exception('Company not found.');
            }

            $campaign->visualized = ($campaign->visualized + 1);
            $campaign->save();

            return response()->json($campaign, 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function filtered(Request $request)
    {
        $campaigns = ResourcesCampaigns::getCampaignsFunnel($request->get('data'));

        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $campaigns,
        ], 200);
    }
}