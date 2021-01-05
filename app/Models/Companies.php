<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

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
        'name',
        'cnpj',
        'nickname',
        'user_id_created',
        'user_id_updated',
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

    public function companies()
    {
        return $this->hasOne('App\Models\Campaigns', 'companies_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() :\Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\Users', 'users_has_companies','companies_id', 'users_id');
    }
}