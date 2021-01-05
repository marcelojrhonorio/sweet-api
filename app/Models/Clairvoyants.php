<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clairvoyants extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'first_name',
        'email_address',
        'birthdate',
        'gender',
        'ddd_home',
        'phone_home',
        'lead',
        'pixel',
    ];

}
