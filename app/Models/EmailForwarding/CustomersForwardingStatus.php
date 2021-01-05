<?php

namespace App\Models\EmailForwarding;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomersForwardingStatus extends Model
{
    protected $table = "customers_forwarding_status";

    use ModelValidatorTrait;
   
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customers_id',
        'name',
        'email',
        'status',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'        => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
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
