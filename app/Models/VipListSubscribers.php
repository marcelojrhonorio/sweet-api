<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VipListSubscribers extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',        
        'created_at',
        'update_at',
    ];

    protected $fillable = [
        'name',
        'phone', 
    ];

    protected $dates = ['deleted_at'];

}
