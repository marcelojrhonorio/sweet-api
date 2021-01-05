<?php

namespace App\Models\SeguroAuto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use SoftDeletes;

    //protected $connection = env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql');

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $fillable = [
        'brand_name',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'deleted_at',
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicle_models(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\SeguroAuto\VehicleModels', 'id', 'brand_id')->orderBy('vehicle_model_name', 'asc');
    }
}
