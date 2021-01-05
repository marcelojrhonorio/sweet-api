<?php

namespace App\Models\Stamp;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerStamp extends Model
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
        'stamps_id', 
        'count_to_stamp',
        'send_email_at',
    ];

    private $rules;

    private $erros;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        
        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'      => 'required|exists:'.env('DB_CONNECTION', 'mysql') . '.customers,id',
            'stamps_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql') . '.stamps,id',
            'count_to_stamp'    => 'required|integer',
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
    public function stamp_customers(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }    
}
