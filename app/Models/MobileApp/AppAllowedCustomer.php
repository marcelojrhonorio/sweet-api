<?php

namespace App\Models\MobileApp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppAllowedCustomer extends Model
{
    use SoftDeletes;
    
    protected $table = "app_allowed_customers";

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
        'access_expired_at', 
    ];

    protected $dates = [
        'deleted_at',
    ];

}
