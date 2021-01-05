<?php

namespace App\Models\ProductServiceStamp;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class ProductServiceStamp extends Model
{
    protected $table = "product_service_stamps";

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
        'stamps_id', 
        'product_id',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'stamps_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.stamps,id',
            'product_id'        => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.products_services,id',
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function stamp(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Stamp\Stamp', 'stamps_id', 'id');
    } 

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\ProductsServices', 'product_id', 'id');
    }
}
