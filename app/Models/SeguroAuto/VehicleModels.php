<?php

namespace App\Models\SeguroAuto;

use Illuminate\Database\Eloquent\Model;

class VehicleModels extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $appends = ['min_year', 'max_year'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\Brands', 'brand_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\VehicleTypes', 'vehicle_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function years(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\SeguroAuto\Years', 'model_years', 'vehicle_model_id', 'year_id');
    }

    // New Mutators :D
    public function getMinYearAttribute()
    {
        //var_dump($this);
        if (count($this->relations)) {
            return min(array_column($this->relations['years']->toArray(), 'year_description'));
        }

        return null;
    }

    public function getMaxYearAttribute()
    {
        if (count($this->relations)) {
            return max(array_column($this->relations['years']->toArray(), 'year_description'));
        }

        return null;
    }
}
