<?php

namespace App\Models\Researches;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class ResearcheAnswer extends Model
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
        'customers_id', 'respondent', 'researches_id', 'questions_id', 'options_id',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_RESEARCHES', 'researches_mysql');
        $this->rules = [
            'respondent'     => 'required|string',
            'researches_id'  => 'required|exists:'.env('DB_CONNECTION_RESEARCHES', 'researches_mysql').'.researches,id',
            'questions_id'   => 'required|exists:'.env('DB_CONNECTION_RESEARCHES', 'researches_mysql').'.questions,id',
            'options_id'     => 'required|exists:'.env('DB_CONNECTION_RESEARCHES', 'researches_mysql').'.options,id',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function researche(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Researches\Researche', 'researches_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Researches\Question', 'questions_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Researches\Option', 'options_id', 'id');
    }
}