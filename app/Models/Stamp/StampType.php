<?php

namespace App\Models\Stamp;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class StampType extends Model
{
    use ModelValidatorTrait;

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    protected $fillable = [
        'title', 
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'title'          => 'required|string',
        ];
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stamps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Stamp\Stamp', 'type', 'id');
    }   
   

}
