<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surveis extends Model
{
    protected $fillable = [
        'survey_id',     
        'survey_type',   
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers');
    }

    public function action()
    {
        return $this->belongsTo('App\Models\Action');
    }
}




