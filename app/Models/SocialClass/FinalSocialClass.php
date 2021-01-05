<?php

namespace App\Models\SocialClass;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class FinalSocialClass extends Model
{
    use ModelValidatorTrait;

    protected $table = 'final_social_class';

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
        'customers_id', 'final_points', 'final_class_by_income', 'final_class_by_questions', 'earned_points',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql');
        $this->rules = [
            'customers_id'             =>  'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'final_points'             =>  'required|integer',
            'final_class_by_income'    =>  'string',
            'final_class_by_questions' =>  'string',
            'earned_points' => 'integer'
        ];
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }
}
