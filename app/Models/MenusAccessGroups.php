<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusAccessGroups extends Model
{

    protected $table = 'menus_access_groups';

    protected $fillable = [
        'menus_id',
        'access_groups_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menus()
    {
        return $this->belongsTo('App\Models\Menus', 'menus_id', 'id');
    }

    public function accessGroups()
    {
        return $this->hasOne('App\Models\AccessGroups', 'id', 'access_groups_id');
    }

}