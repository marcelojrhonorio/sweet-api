<?php

namespace App\Models\Ssi;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class SsiProjectRespondent extends Model
{
    use ModelValidatorTrait;

    //
    protected $fillable = [
        'startUrlId', 'respondentId', 'ssi_project_id', 'status', 'point',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $rules;

    protected $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->rules = [
            'ssi_project_id' => 'required|integer',
            'respondentId' => 'required|integer',
            'startUrlId' => 'required|string',
        ];
    }
}
