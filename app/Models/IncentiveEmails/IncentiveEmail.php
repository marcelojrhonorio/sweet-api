<?php

namespace App\Models\IncentiveEmails;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class IncentiveEmail extends Model
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
    protected $fillable = ['title', 'description', 'points', 'redirect_link', 'code'];
    
    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'title'         => 'required|string',
            'description'   => 'string',
            'points'        => 'required|integer',
            'redirect_link' => 'required|string',
            'code'          => 'string',
        ];
    }   
    
}
