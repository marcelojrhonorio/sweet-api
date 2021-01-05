<?php

namespace App\Models\MobileApp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppWaitingList extends Model
{
    use SoftDeletes;

    protected $table = "app_waiting_list";
    
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customers_id', 
    ];

    protected $dates = [
        'deleted_at',
    ];
}
