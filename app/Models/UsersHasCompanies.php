<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersHasCompanies extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_has_companies';
    /**
     * The fields allows fill
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'companies_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\Models\Users', 'users_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies()
    {
        return $this->belongsTo('App\Models\Companies', 'companies_id', 'id');
    }

}