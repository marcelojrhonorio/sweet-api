<?php

namespace App\Models;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class UnsubscribedCustomer extends Model
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
        'reasons', 
        'another_reason_description',
        'suggestion',
        'final_option',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'               => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'reasons'                    => 'required|string',
            'final_option'               => 'required|string',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unsubscribed_customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }
}