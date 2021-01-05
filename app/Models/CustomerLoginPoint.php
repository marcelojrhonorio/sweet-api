<?php

namespace App\Models;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerLoginPoint extends Model
{
    protected  $table = 'sweet.customers_login_points';
    
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
        'total_logins', 
        'last_customer_login_points_at',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'                  => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'total_logins'                  => 'required|integer',
            'last_customer_login_points_at' => 'required',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }
}
