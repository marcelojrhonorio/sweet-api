<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customers extends Model
{
    use SoftDeletes;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'points',
        'confirmed',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
    }

    /**
     * Get the campaign answers for the customer.
     */
    public function answers()
    {
        return $this->hasMany('App\Models\CampaignAnswers', 'customers_id', 'id');
    }

    /**
     * Get the checkins for the customer.
     */
    public function checkins()
    {
        return $this->hasMany('App\Models\Checkin');
    }
}
