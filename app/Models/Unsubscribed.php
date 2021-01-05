<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unsubscribed extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers');
    }
}
