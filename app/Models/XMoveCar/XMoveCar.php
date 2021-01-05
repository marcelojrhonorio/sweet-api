<?php

namespace App\Models\XMoveCar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XMoveCar extends Model
{
    protected $table = 'sweet_xmovecar.xmove_cars';

    use SoftDeletes;

     /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cell_phone',
        'occupation',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'deleted_at',
    ];

}
