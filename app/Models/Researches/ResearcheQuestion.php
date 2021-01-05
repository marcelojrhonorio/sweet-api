<?php

namespace App\Models\Researches;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResearcheQuestion extends Model
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
        'researches_id', 'questions_id', 'ordering',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_RESEARCHES', 'researches_mysql');
        $this->rules = [            
            'researches_id'  => 'required|exists:'.env('DB_CONNECTION_RESEARCHES', 'researches_mysql').'.researches,id',
            'questions_id'   => 'required|exists:'.env('DB_CONNECTION_RESEARCHES', 'researches_mysql').'.questions,id',
            'ordering'       => 'required|integer',
        ];
    }

    protected $dates = ['deleted_at'];

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
}