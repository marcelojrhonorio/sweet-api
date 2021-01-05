<?php

namespace App\Models\CustomerAddress;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = "customer_address";

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
        'cep',
        'street',
        'number',
        'complement',
        'reference_point',
        'neighborhood',
        'city',
        'state',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'cep'                  => 'required|string',
            'street'               => 'required|string',
            'number'               => 'required|string',
            'complement'           => 'required|string',
            'reference_point'      => 'required|string',
            'neighborhood'         => 'required|string',
            'city'                 => 'required|string',
            'state'                => 'required|string',
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
