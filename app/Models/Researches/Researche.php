<?php

namespace App\Models\Researches;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Researche extends Model
{
    use ModelValidatorTrait;
    use SoftDeletes;

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
        'title', 'subtitle', 'description', 'points', 'final_url', 'enabled',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_RESEARCHES', 'researches_mysql');
        $this->rules = [            
            'title'        => 'required|string',
            'subtitle'     => 'required|string',
            'description'  => 'required|string',
            'points'       => 'required|integer',
            'final_url'    => 'required|string',
            'enabled'      => 'required|boolean',
        ];
    }

    protected $dates = ['deleted_at'];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function question(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Researches\ResearcheQuestion', 'researches_id', 'id');
    }
}