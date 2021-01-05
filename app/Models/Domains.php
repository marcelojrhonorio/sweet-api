<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'domains';

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
        'name',
        'link',
        'status',
        'user_id_created',
        'user_id_updated',
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
        //return $this->belongsToMany('App\Models\Campaigns', 'campaigns_has_domains','campaigns_id', 'domains_id');
        return $this->belongsToMany('App\Models\Campaigns', 'campaigns_has_domains','domains_id', 'campaigns_id');
    }

}
