<?php

namespace App\Models\SeguroAuto;

use Illuminate\Database\Eloquent\Model;

class ModelYears extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle_model(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\VehicleModels', 'vehicle_model_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function year(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\Years', 'year_id', 'id');
    }
}
