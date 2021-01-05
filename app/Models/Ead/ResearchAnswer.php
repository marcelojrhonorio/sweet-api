<?php

namespace App\Models\Ead;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class ResearchAnswer extends Model
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
        'research_id', 'question_id', 'option_id',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_EAD', 'ead_mysql');
        $this->rules = [
            'research_id'       => 'required|string',
            'question_id'       => 'required|exists:'.env('DB_CONNECTION_EAD', 'ead_mysql').'.research_questions,id',
            'option_id'         => 'required|exists:'.env('DB_CONNECTION_EAD', 'ead_mysql').'.research_options,id',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function research_question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Ead\ResearchQuestion', 'question_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function research_option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Ead\ResearchOption', 'option_id', 'id');
    } 
}
