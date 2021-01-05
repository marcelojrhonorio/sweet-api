<?php

namespace App\Models\Interests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterestType extends Model
{
    protected $table = "interest_types";

    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $fillable = [
        'title',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'deleted_at',
    ];
}
