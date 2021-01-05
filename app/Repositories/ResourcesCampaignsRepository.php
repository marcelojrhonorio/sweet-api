<?php

namespace App\Repositories;

use App\Models\CampaignAnswers;
use App\Models\Campaigns;
use App\Models\CampaignTypes;
use App\Models\Clusters;
use App\Models\Companies;
use App\Models\Domains;
use App\Repositories\Contracts\ResourcesCampaignsInterface;
use DB;

class ResourcesCampaignsRepository implements ResourcesCampaignsInterface
{
    private $models = [];

    public function __construct()
    {
        $this->models = [
            'CampaignTypes' => new CampaignTypes(),
            'Companies' => new Companies(),
            'Domains' => new Domains(),
            'Clusters' => new Clusters(),
            'Campaigns' => new Campaigns(),
        ];
    }

    public function findTypes(bool $isActive = true)
    {
        $result = $this->models['CampaignTypes']::select('id', 'type')->orderBy('id');

        if ($isActive) {
            $result->where('status', '=', 1);
        }

        if (!$result) {
            throw new \Exception('Campaign Types Active not found');
        }

        return $result->get();
    }

    public function findCompanies(bool $isActive = true)
    {
        $result = $this->models['Companies']::select('id', 'nickname', 'cnpj')->orderBy('nickname');

        if ($isActive) {
            $result->where('status', '=', 1);
        }

        if (!$result) {
            throw new \Exception('Companies Active not found');
        }

        return $result->get();
    }

    public function findDomains(bool $isActive = true)
    {
        $result = $this->models['Domains']::select('id', 'link')->orderBy('id');

        if ($isActive) {
            $result->where('status', '=', 1);
        }

        if (!$result) {
            throw new \Exception('Domains Active not found');
        }

        return $result->get();
    }

    public function findClusters(bool $isActive = true)
    {
        $result = $this->models['Clusters']::select('id', 'cluster')->orderBy('cluster');

        if ($isActive) {
            $result->where('status', '=', 1);
        }

        if (!$result) {
            throw new \Exception('Clusters Active not found');
        }

        return $result->get();
    }

    public function findCampaigns(bool $isActive = true)
    {
        $result = $this->models['Campaigns']::select('id', 'name')->orderBy('name');

        if ($isActive) {
            $result->where('status', '=', 1);
        }

        if (!$result) {
            throw new \Exception('Campaigns Active not found');
        }

        return $result->get();
    }

    private function findOrderExists(int $order, int $id, int $userId)
    {
        $entity = Campaigns::where('order', '=', $order)->first();

        if ($entity) {

            $orderNumber = $order;
            $entities = Campaigns::where('order', '>=', $order)
                ->where('id', '!=', $id)
                ->where('status', 1)
                ->select('id')
                ->orderBy('order', 'ASC')
                ->get();

            foreach ($entities as $entity) {
                $orderNumber++;
                $campaign = Campaigns::findOrFail($entity['id']);
                $campaign->order = $orderNumber;
                $campaign->user_id_updated = $userId;
                $campaign->save();
            }
        }
    }

    public function save(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $campaign = Campaigns::create(array_merge($data['campaigns'], ['user_id_created' => $userId]));
            if (isset($data['campaigns']['campaing_types_id']) && $data['campaigns']['campaing_types_id'] === "7") {
                $campaign->fields()->createMany($data['catch_inputs']);
            }
            $campaign->clickout()->createMany($data['campaigns_clickout']);
            $campaign->domains()->attach($data['domains']);
            $campaign->clusters()->attach($data['clusters']);

            $this->findOrderExists($data['campaigns']['order'], $campaign->id, $userId);

            DB::commit();

            return $campaign;
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function update(array $data, int $id, int $userId)
    {
        DB::beginTransaction();

        try {

            $this->findOrderExists($data['campaigns']['order'], $id, $userId);

            $campaign = Campaigns::findOrFail($id);
            $campaign->fill($data['campaigns']);
            $campaign->user_id_updated = $userId;
            $campaign->save();

            //$campaign->domains()->updateExistingPivot($campaign->id);
            //$campaign->clusters()->updateExistingPivot($campaign->id);

            $campaign->domains()->detach();
            $campaign->clusters()->detach();

            $campaign->domains()->attach($data['domains']);
            $campaign->clusters()->attach($data['clusters']);

            DB::commit();
            return $campaign;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public static function getCampaignAnswersByCustomer(int $customer)
    {
        $campaigns = [];
        $entities = CampaignAnswers::where('customers_id', '=', $customer)->select('campaigns_id')->distinct('campaigns_id')->get();

        foreach ($entities as $entity) {
            $campaigns[] = $entity->campaigns_id;
        }

        return $campaigns;
    }

    public static function getCampaignsFunnel(array $data)
    {

        $idCampaings = self::getCampaignAnswersByCustomer($data['idCustomer']);

        $campaigns = Campaigns::with([
            'clickout',
            'domains',
            'types',
        ])->where([
            'status' => 1,
        ])
            ->where(function ($query) use ($data) {
                $query
                    ->orWhere('desktop', $data['desktop'])
                    ->orWhere('mobile', $data['mobile']);
            });

        if (count($idCampaings) > 0) {
            $campaigns = $campaigns->whereNotIn('campaigns.id', $idCampaings);
        }

        $campaigns = $campaigns->whereHas('domains', function ($query) use ($data) {
            $query->where('domains.name', $data['domainName']);
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
                'campaigns.order',
                'filter_ddd',
                'filter_gender',
                'filter_cep',
                'filter_operation_begin',
                'filter_age_begin',
                'filter_operation_end',
                'filter_age_end'
            )
            ->orderBy('campaigns.order', 'ASC')
            ->get();
        // echo $campaigns->toSql();

        $age = false;
        if (!empty($data['birthdate'])) {
            $age = (int) ageCalculate($data['birthdate'])['year'];
        }

        $cep = false;
        if (!empty($data['cep'])) {
            $cep = returnNumber($data['cep']);
        }

        $ddd = false;
        if (!empty($data['phone'])) {
            $ddd = substr(returnNumber($data['phone']), 0, 2);
        }

        $campaignsFiltered = [];

        foreach ($campaigns as $campaign) {

            $campaignAvailable = true;

            if ((!empty($data['gender']) && !empty($campaign['filter_gender'])) && $data['gender'] != $campaign['filter_gender']) {
                $campaignAvailable = false; //continue;
            }

            if ($ddd && !empty($campaign['filter_ddd'])) {
                if (!in_array($ddd, explode('|', $campaign['filter_ddd']))) {
                    $campaignAvailable = false; //continue;
                }
            }

            if ($cep && !empty($campaign['filter_cep'])) {
                if (!in_array($cep, explode('|', $campaign['filter_cep']))) {
                    $campaignAvailable = false; //continue;
                }
            }

            if ($age) {

                switch ($campaign['filter_operation_begin']) {
                    case '=':
                        if (!($age == $campaign['filter_age_begin'])) {
                            $campaignAvailable = false;
                        }
                        break;
                    case '<':
                        if (!($age < $campaign['filter_age_begin'])) {
                            $campaignAvailable = false;
                        }
                        break;
                    case '<=':
                        if (($age <= $campaign['filter_age_begin'])) {
                            $campaignAvailable = false;
                        }
                        break;
                    case '<>':
                        if (($age != $campaign['filter_age_begin'])) {
                            $campaignAvailable = false;
                        }
                        break;
                    case '>':
                        if ($campaign['filter_operation_end'] == '<') {
                            if (!($age > $campaign['filter_age_begin'] && $age < $campaign['filter_age_end'])) {
                                $campaignAvailable = false;
                            }
                        } elseif ($campaign['filter_operation_end'] == '<=') {
                            if (($age > $campaign['filter_age_begin'] && $age <= $campaign['filter_age_end'])) {
                                $campaignAvailable = false;
                            }
                        }
                        break;
                    case '>=':

                        if ($campaign['filter_operation_end'] == '<') {
                            if (!($age >= $campaign['filter_age_begin'] && $age < $campaign['filter_age_end'])) {
                                $campaignAvailable = false;
                            }
                        } elseif ($campaign['filter_operation_end'] == '<=') {
                            if (!($age >= $campaign['filter_age_begin'] && $age <= $campaign['filter_age_end'])) {
                                $campaignAvailable = false;
                            }
                        }
                        break;
                }
            }

            if (!$campaignAvailable) {
                continue;
            }

            $campaignsFiltered[] = $campaign;
        }

        return $campaignsFiltered;
    }

}
