<?php

namespace App\Models\SeguroAuto;

use Illuminate\Database\Eloquent\Model;

class VehicleTypes extends Model
{
    //
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
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
        return $this->hasMany('App\Models\SeguroAuto\VehicleModels', 'id', 'vehicle_type_id')->orderBy('vehicle_model_name', 'asc');
    }
}
