<?php

namespace App\Models\SocialClass;

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
        'customers_id', 'question_id', 'option_id',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql');
        $this->rules = [
            'customers_id' => 'required',
            'question_id'  => 'required|exists:'.env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql').'.research_questions,id',
            'option_id'    => 'required|exists:'.env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql').'.research_options,id',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function research_question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SocialClass\ResearchQuestion', 'question_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function research_option(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SocialClass\ResearchOption', 'option_id', 'id');
    }
}
