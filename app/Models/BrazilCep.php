<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrazilCep extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cep',
        'cidade',
        'estado',
    ];
}
