<?php

namespace App\Models\Researches;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use ModelValidatorTrait;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'one_answer', 'extra_information',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_RESEARCHES', 'researches_mysql');
        $this->rules = [
            'description'      => 'required',
            'one_answer'       => 'required|boolean',
        ];
    }

    protected $dates = ['deleted_at'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function question_option(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Researches\QuestionOption', 'questions_id', 'id');
    }
}