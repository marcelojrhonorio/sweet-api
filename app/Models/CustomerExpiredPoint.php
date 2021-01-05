<?php

namespace App\Models;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerExpiredPoint extends Model
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
        'customers_id', 
        'points', 
        'previous_ballance',
        'balance_after',
        'divergence',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'      => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'points'            => 'required|integer',
            'previous_ballance' => 'required|integer',
            'balance_after'     => 'required|integer',
            'divergence'        => 'required|integer',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expired_points_customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }
}
