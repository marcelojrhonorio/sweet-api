<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessGroups extends Model
{

    protected $table = 'access_groups';

    protected $fillable = [
        'name',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    public function users()
    {
        return $this->hasMany('App\Models\Users','access_groups_id', 'id');
    }

    public function menus()
    {
        return $this->hasMany('App\Models\MenusAccessGroups','access_groups_id', 'id');
    }
}