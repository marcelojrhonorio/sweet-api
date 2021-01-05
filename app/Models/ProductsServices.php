<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsServices extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_services';
    /**
     * The table primary key name
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * The fields allows fill
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'path_image',
        'points',
        'status',
        'category_id',
        'user_id_created',
        'user_id_updated',
    ];
    /**
     * The fields does not allows fill
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productsServicesCategories() :\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\ProductsServicesCategories','category_id', 'id');
    }
}