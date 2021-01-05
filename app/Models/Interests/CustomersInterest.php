<?php

namespace App\Models\Interests;

use Illuminate\Database\Eloquent\Model;

class CustomersInterest extends Model
{
    protected $table = "customers_interests";

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $fillable = [
        'interest_types_id',
        'customers_id',
        'interest',
    ];
   
    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'      => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'interest_types_id' => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.interest_types,id',
            'interest'          => 'required|string',
        ];
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }

    public function interest_types(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Interests\InterestType', 'interest_types_id', 'id');
    }
}
