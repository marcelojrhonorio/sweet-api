<?php

namespace App\Models\SeguroAuto;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerResearches extends Model
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
        'has_car','completed', 'customer_research_points', 'customer_id',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql');
        $this->rules = [
            'has_car'   => 'boolean',
            'completed' => 'sometimes|integer',
            'customer_research_points' => 'required|integer',
            'customer_id' => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customer_id', 'id');
    }
}
