<?php

namespace App\Models;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerDevice extends Model
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
        'browser_name', 
        'browser_family',
        'platform_name',
        'platform_family',
        'device_family',
        'device_model',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'    => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'browser_name'    => 'required|string',
            'browser_family'  => 'required|string',
            'platform_name'   => 'required|string',
            'platform_family' => 'required|string',
            'device_family'   => 'string',
            'device_model'    => 'string',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer_device_customers(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }
}