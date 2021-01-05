<?php

namespace App\Models\Exchange;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerExchangedPoint extends Model
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
        'product_services_id', 
        'points',
        'status_id',
        'cep',
        'address',
        'number',
        'reference_point',
        'neighborhood',
        'city',
        'complement',
        'state',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'points'               => 'required|integer|min:1',
            'customers_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'product_services_id'  => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.products_services,id',
            'status_id'            => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.exchanged_points_status,id',
            'cep'                  => 'required|string',
            'address'              => 'required|string',
            'number'               => 'required|string',
            'reference_point'      => 'required|string',
            'neighborhood'         => 'required|string',
            'city'                 => 'required|string',
            'complement'           => 'string',
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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\ProductsServices', 'product_services_id', 'id');
    }     

}
