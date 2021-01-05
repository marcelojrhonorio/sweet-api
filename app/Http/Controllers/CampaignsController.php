<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Campaigns;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $filters = [];
        $filterIn = '';
      //  $campaigns = new Campaigns();

        //if ($request->hasAny(['name', 'id_has_offers', 'companies_id', 'campaign_types_id', 'status'])) {

        foreach ($request->all() as $key => $value) {

            if ($key == 'userid' || $value == '') {
                continue;
            }

            if ($key == 'companies_id') {
                $filterIn = $value;
                continue;
            }

            $filters['campaigns.'.$key] = $value;
        }

       //}

        if (!array_key_exists('campaigns.status', $filters)) {
            $filters['campaigns.status'] = 1;
        }

        $campaigns = DB::table('campaigns')
                        ->select(
                            'campaigns.id',
                            'campaigns.name',
                            'campaigns.title',
                            'campaigns.question',
                            'campaigns.path_image',
                            'campaigns.path_thumbnail',
                            'campaigns.status',
                            'campaigns.mobile',
                            'campaigns.desktop',
                            'campaigns.postback_url',
                            'campaigns.config_page',
                            'campaigns.config_email',
                            'campaigns.visualized',
                            'campaigns.id_has_offers',
                            'campaigns.campaign_types_id',
                            'companies_id',
                            'campaigns.order',
                            DB::raw('(select count(c.id) from campaign_answers c where c.campaigns_id = campaigns.id) AS total_answers' )
                        )
                        ->groupBy('campaigns.id')
                        ->orderBy('campaigns.order');

                if (!empty($filterIn)) {
                    $campaigns->whereIn('campaigns.companies_id', explode(',', $filterIn));
                }

                if (count($filters) > 0) {
                    $campaigns->where($filters);
                }
       // echo $campaigns->toSql();

        return response()->json([
            /*'metadata' => [
                'resultset' => [
                    'count' => 0,
                    'offset' => 0,
                    'limit' => 10
                ],
            ],*/
            'results' => $campaigns->get(),
        ], 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function find(int $id) : \Illuminate\Http\JsonResponse
    {
        $campaign  = Campaigns::where('id', $id)->with(Campaigns::getCampaignRelations());

        if (is_null($campaign)) {
            throw new \Exception('Campaign not found.');
        }

        return response()->json(['result' => $campaign->first()], 200);
    }

    public function getCampaign($campaign_id)
    {
        $campaign  = Campaigns::find($campaign_id) ?? null;
       
        return $campaign;
       
    }

    public function store(Request $request)
    {
        $campaign = $this->resources->save(
            $request->get('data'),
            $request->get('userid')
        );

        $headerLocation = sprintf('%s/%d', $request->url(), $campaign->id);

        return response()->json([
            'status' => 'success',
            'result' => $campaign,
        ], 201, ['Location' => $headerLocation]);
    }

    public function update(Request $request, $id)
    {
        $campaign = $this->resources->update($request->get('data'), $id, $request->get('userid'));

        $headerLocation = sprintf('%s/%d', $request->url(), $campaign->id);
        return response()->json([
            'status' => 'success',
            'result' => $campaign,
        ], 201, ['Location' => $headerLocation]);
    }

    public function destroy($id)
    {}

    public function resources(Request $request)
    {
        $types = [];
        $companies = [];
        $domains = [];
        $clusters = [];
        $campaigns = [];

        try {

            if ($request->has('q')) {

                $queryString = explode('|', $request->get('q'));

                $status = (bool)($request->get('status') ?? 1);

               // dd($status, $request->get('status'));
                foreach ($queryString as $value) {

                    $method = 'find' . ucfirst($value);
                    if (!method_exists($this->resources,  $method)) {
                        throw new \Exception('Method not exists');
                    }

                    ${$value} = $this->resources->{$method}($status);
                }

            } else {
                //CampaignTypes
                $types = $this->resources->findTypes();
                //CompaniesActive
                $companies = $this->resources->findCompanies();
                //DomainsActive
                $domains = $this->resources->findDomains();
                //ClustersActive
                $clusters = $this->resources->findClusters();
                //CampaignsActive
                $campaigns = $this->resources->findCampaigns();
            }

            return response()->json([
                /*'metadata' => [
                    'resultset' => [
                        'count' => 0,
                        'offset' => 0,
                        'limit' => 10
                    ],
                ],*/
                'results' => [
                    'campaignsType' => $types,
                    'companies' => $companies,
                    'domains' => $domains,
                    'clusters' => $clusters,
                    'campaigns' => $campaigns,
                ],
            ], 200);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update partial fields the specified Campaign
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function patch(Request $request, int $id)
    {
        $fields = [];

        $campaign  = Campaigns::findOrFail($id);

        if (is_null($campaign)) {
            throw new \Exception('Company not found.');
        }

        foreach ($request->all() as $key => $value) {
            if ($key == 'userid') {
                continue;
            }
            $campaign->{$key} = $value;
        }

        $campaign->user_id_updated = $request->get('userid');
        $campaign->save();
        return response()->json($campaign, 200);
    }

    public function getMaxOrderNumber()
    {
        $result = DB::table('campaigns')->max('order');

        return response()->json([
            'results' => [
                'order' => ($result + 1),
            ],
        ], 200);
    }
}
