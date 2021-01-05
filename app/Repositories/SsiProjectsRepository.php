<?php

namespace App\Repositories;

use App\Models\Ssi\SsiProject;

class SsiProjectsRepository
{
    private $_model;

    public function __construct(SsiProject $model)
    {
        $this->_model = $model;
    }

    public function create(array $data = [])
    {
        return $this->_model->create($data);
    }

    public function find(array $data = [])
    {
        return $this->_model->where('contactMethodId', $data['contactMethodId'])
            ->where('projectId', $data['projectId'])
            ->where('startUrlHead', $data['startUrlHead'])
            ->first();
    }
}
