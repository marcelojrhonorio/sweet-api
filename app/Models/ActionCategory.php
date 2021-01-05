<?php
/**
 * @todo Add docs.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @todo Add docs.
 */
class ActionCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the actions for the category.
     */
    public function actions()
    {
        return $this->hasMany('App\Models\Action');
    }
}
