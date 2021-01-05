<?php

namespace App\Models\Alfacon;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class LeadResponse extends Model
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
        'fullname', 'email', 'phone', 'site_origin', 'response'
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_ALFACON', 'alfacon_mysql');
        $this->rules = [
            'fullname'    => 'required|string',
            'email'       => 'required|string',
            'phone'       => 'required|string',  
            'site_origin' => 'required|string',
            'response'    => 'required|string',
        ];
    }
}
