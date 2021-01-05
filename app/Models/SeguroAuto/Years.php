<?php

namespace App\Models\SeguroAuto;

use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function models(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\SeguroAuto\VehicleModels', 'model_years', 'year_id', 'vehicle_model_id');
    }
}
