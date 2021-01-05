<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPasswordReset extends Model
{
    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at',
        'update_at',
    ];

    /**
     * Get the customer for the password reset.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customers', 'email', 'email');
    }
}
