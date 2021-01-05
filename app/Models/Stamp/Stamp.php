<?php

namespace App\Models\Stamp;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
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
        'title', 
        'description', 
        'icon', 
        'type',
        'required_amount'
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'title'             => 'required|string',
            'description'       => 'required|string',
            'icon'              => 'required|string',
            'type'              => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.stamp_types,id',
            'required_amount'   => 'required|integer',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stamp_types(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Stamp\StampType', 'type', 'id');
    }

   
}
