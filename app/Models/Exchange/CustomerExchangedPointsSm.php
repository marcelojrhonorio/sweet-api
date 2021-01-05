<?php

namespace App\Models\Exchange;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerExchangedPointsSm extends Model
{
    use ModelValidatorTrait;

    protected $table = 'sweet.customer_exchanged_points_sm';
    
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
        'social_media',
        'subject',
        'profile_picture',
        'profile_link',
        'status',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [            
            'customers_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'product_services_id'  => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.products_services,id',
            'points'               => 'required|integer|min:1',
            'social_media'         => 'required|string',
            'subject'              => 'required|string',
            'profile_picture'      => 'required|string',
            'profile_link'         => 'required|string',
            'status'               => 'required|string',
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
