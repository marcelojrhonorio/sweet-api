<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignAnswers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaign_answers';
    /**
     * The table primary key name
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The fields allows fill
     *
     * @var array
     */
    protected $fillable = [
        'answer',
        'campaigns_id',
        'customers_id',
    ];

    /**
     * The fields does not allows fill
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaigns()
    {
        return $this->belongsTo('App\Models\Campaigns', 'campaigns_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers()
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }
}