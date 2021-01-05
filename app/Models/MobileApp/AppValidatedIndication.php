<?php

namespace App\Models\MobileApp;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class AppValidatedIndication extends Model
{
    protected $table = "app_validated_indications";

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
        'indicated_id',
        'points',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'indicated_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
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
    public function indicated(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'indicated_id', 'id');
    }
}
