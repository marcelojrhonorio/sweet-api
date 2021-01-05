<?php

namespace App\Models\GreenpeaceOceanos;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class ResearchOption extends Model
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
        'question_id', 'description', 
    ];
    
    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_GREENPEACE_OCEANOS', 'greenpeace_oceanos_mysql');
        $this->rules = [
            'question_id'          => 'required|exists:'.env('DB_CONNECTION_GREENPEACE_OCEANOS', 'greenpeace_oceanos_mysql').'.research_questions,id',
            'description'          => 'required|string',
        ];        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function research_question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\GreenpeaceOceanos\ResearchQuestion', 'question_id', 'id');
    }        
}
