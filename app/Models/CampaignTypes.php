<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignTypes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaign_types';
    /**
     * The table primary key name
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var array
     */
    protected $fillable = [
        'type'
    ];
    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    public function types()
    {
        return $this->hasOne('App\Models\Campaigns', 'campaign_types_id', 'id');
    }
}




