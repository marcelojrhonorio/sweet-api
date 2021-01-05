<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignsHasCrusters extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaigns_has_crusters';
    /**
     * @var array
     */
    protected $fillable = [
        'campaigns_id',
        'clusters_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clusters()
    {
        return $this->belongsTo('App\Models\Clusters', 'clusters_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaigns()
    {
        return $this->belongsTo('App\Models\Campaigns', 'campaigns_id', 'id');
    }
}




