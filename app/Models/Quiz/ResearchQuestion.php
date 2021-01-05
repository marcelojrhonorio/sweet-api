<?php

namespace App\Models\Quiz;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class ResearchQuestion extends Model
{
    use ModelValidatorTrait;

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
        'description', 'one_answer',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_QUIZ', 'quiz_mysql');
        $this->rules = [
            'description'          => 'required|string',
            'one_answer'           => 'required|boolean',
            'extra_information'    => 'string',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function research_options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Quiz\ResearchOption', 'question_id', 'id');
    }    
}
