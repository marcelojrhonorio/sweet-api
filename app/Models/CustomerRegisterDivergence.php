<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRegisterDivergence extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_register_divergences';

    /**
     * @var array
     */
    protected $fillable = [
        'customers_id',
        'invalid_cep',
        'invalid_ddd',
    ];

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];
}
