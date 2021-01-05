<?php

namespace App\Repositories;

use App\Models\Ssi\SsiProjectRespondent;

class SsiProjectRespondentsRepository
{
    private $_model;

    public function __construct(SsiProjectRespondent $model)
    {
        $this->_model = $model;
    }

    public function create(array $data = [])
    {
        return $this->_model->create($data);
    }
}
