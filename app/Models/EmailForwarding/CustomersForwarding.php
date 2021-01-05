<?php

namespace App\Models\EmailForwarding;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomersForwarding extends Model
{
    protected $table = "customers_forwarding";

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
        'email_forwarding_id', 
        'customers_id',
        'won_points',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'email_forwarding_id' => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.email_forwarding,id',
            'customers_id'        => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function forwarding(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\EmailForwarding\EmailForwarding', 'email_forwarding_id', 'id');
    } 

     /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    } 
}
