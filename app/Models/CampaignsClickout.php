<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignsClickout extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campaigns_clickout';
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
        'affirmative',
        'link',
        'campaigns_id',
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

    public function campaigns()
    {
        return $this->belongsTo('App\Models\Campaings', 'campaigns_id', 'id');
    }
}
