<?php

namespace App\Models\Ambev;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class AmbevCustomer extends Model
{
    use ModelValidatorTrait;

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'language', 'region', 'template', 'fired_email', 'answered'
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'user_id'      => 'required|integer',
            'email'        => 'required|string',
            'language'     => 'required|string',
            'region'       => 'required|string',
            'template'     => 'required|string',
            'fired_email'  => 'required|boolean',
        ];
    }    
}
