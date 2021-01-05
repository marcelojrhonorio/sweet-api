<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignsHasDomains extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaigns_has_domains';
    /**
     * The fields allows fill
     *
     * @var array
     */
    protected $fillable = [
        'campaigns_id',
        'domains_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domains()
    {
        return $this->belongsTo('App\Models\Domains', 'domains_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaigns()
    {
        return $this->belongsTo('App\Models\Campaigns', 'campaigns_id', 'id');
    }

}