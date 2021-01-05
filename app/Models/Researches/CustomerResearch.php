<?php

namespace App\Models\Researches;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerResearch extends Model
{
    use ModelValidatorTrait;
    
    protected $table = 'sweet_researches.customers_researches';    

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
        'researches_id', 'customers_id', 
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_RESEARCHES', 'researches_mysql');
        $this->rules = [
            'researches_id'   => 'required|integer',
            'customers_id'    => 'required|string',
        ];
    }
}
