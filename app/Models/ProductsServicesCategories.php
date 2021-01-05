<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsServicesCategories extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_services_categories';
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
        'name',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function productsServicesCategories()
    {
        return $this->hasMany('App\Models\ProductsServices', 'category_id', 'id');
    }
}
