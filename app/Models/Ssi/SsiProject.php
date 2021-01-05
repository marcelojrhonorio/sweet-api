<?php

namespace App\Models\Ssi;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class SsiProject extends Model
{
    use ModelValidatorTrait;

    protected $fillable = [
        'contactMethodId', 'projectId', 'startUrlHead',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->rules =
            [
            'contactMethodId' => 'required|integer',
            'projectId' => 'required|integer',
            'startUrlHead' => 'required|string',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respondents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Ssi\SsiProjectRespondent', 'ssi_project_id','id')->orderBy('respondentId', 'asc');
    }
}
