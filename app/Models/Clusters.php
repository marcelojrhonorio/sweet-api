<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clusters extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clusters';

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
        'cluster'
    ];
    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaigns() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\Campaigns', 'campaigns_has_clusters','clusters_id', 'campaigns_id');
    }

}
