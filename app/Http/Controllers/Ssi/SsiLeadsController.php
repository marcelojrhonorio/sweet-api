<?php

namespace App\Http\Controllers\Ssi;

use App\Http\Controllers\Controller;
use App\Jobs\AllInInviteSsiProject1WithMarketingEmailJob;
use App\Jobs\SsiSendInviteJob;
use App\Models\Ssi\SsiLeads;
use App\Services\SsiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class SsiLeadsController extends Controller
{
    //
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = [];

    public function __construct(SsiLeads $model)
    {
        $this->model = $model;
    }
    /**
     * Method to get respondent status
     */
    public function showRespondentStatus(Request $request)
    {
        $arrayResponse = ['generalResponseCode' => 201];
        if ($request->isJson()) {
            $data = $request->json()->all();
        } else {
            $data = $request->all();
        }
        // Verificar se o projeto de pesquisa já está criado
        $project = SsiService::createSsiProject(self::parseArrayToProject($data));
        // Se cria a pesquisa e recupera o id

        if (count($data['respondentList']) >= 1) {
            foreach ($data['respondentList'] as $key => $value) {
                // Get the respondent status
                $status = SsiService::getRespondentStatus($this->model, (int) $value['respondentId']);

                if (SsiService::checkStatusError($status)) {
                    $arrayStatus[$status][] = $value['respondentId'];
                    continue;
                }
                // Create a Link to Users :D
                $created_respondent = SsiService::createRespondent(self::parseArrayToRespondent($project->id, $value));
            }
            if (!empty($arrayStatus)) {
                $arrayResponse = ['addtionalResponseCodes' => $arrayStatus];
            }
        }

        $ssi_invite_project_job = new AllInInviteSsiProject1WithMarketingEmailJob($project->id);

        Queue::pushOn('api_ssi_invite_project_all_marketing_email_1', $ssi_invite_project_job);

        return response()->json($arrayResponse)->setStatusCode(201);
    }

    private static function parseArrayToProject(array $data)
    {
        return [
            "contactMethodId" => (int) $data["requestHeader"]["contactMethodId"],
            "projectId" => (int) $data["requestHeader"]["projectId"],
            "startUrlHead" => $data["startUrlHead"],
        ];
    }

    private static function parseArrayToRespondent(int $project_id = null, array $data)
    {
        return $data += ['ssi_project_id' => $project_id];
    }
}
