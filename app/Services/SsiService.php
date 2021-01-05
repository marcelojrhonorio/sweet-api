<?php

namespace App\Services;

use App\Models\Ssi\SsiLeads;
use App\Models\Ssi\SsiProject;
use App\Models\Ssi\SsiProjectRespondent;
use App\Repositories\SsiProjectRespondentsRepository;
use App\Repositories\SsiProjectsRepository;
use Illuminate\Support\Facades\Log;

class SsiService
{
    private static $_code_errors = [
        202, 205,
    ];

    public static function checkStatusError(int $status = null)
    {
        return in_array($status, self::$_code_errors);
    }

    public static function getRespondentStatus(SsiLeads $model, int $id = null)
    {
        try {
            $result = $model->where('id', $id)->first();
        } catch (QueryException $e) {
            Log::debug("Query Exception -> {$e->getMessage()}");
            return 202;
        } catch (PDOException $e) {
            Log::debug("Pdo Exception -> {$e->getMessage()}");
            return 202;
        } catch (\Exception $e) {
            Log::debug("Generally Exception -> {$e->getMessage()}");
            return 202;
        }
        if (!empty($result)) {
            if (empty($result->deleted_at) || null == $result->deleted_at || $result->deleted_at == '') {
                return 201;
            }
            return 205;
        }
        return 202;
    }

    private static function getProjectRepository()
    {
        return new SsiProjectsRepository(new SsiProject);
    }

    private static function getProjectRespondentRepository()
    {
        return new SsiProjectRespondentsRepository(new SsiProjectRespondent);
    }

    public static function createSsiProject(array $data = [])
    {
        $repositoryProject = self::getProjectRepository();
        return $repositoryProject->create($data);
    }

    public static function createRespondent(array $data = [])
    {
        $repositoryProjectRespondent = self::getProjectRespondentRepository();
        return $repositoryProjectRespondent->create($data);
    }
}
