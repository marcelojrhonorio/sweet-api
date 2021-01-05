<?php

namespace App\Models\RelationshipRule;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class RelationshipRule extends Model
{
    use ModelValidatorTrait;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'html_message', 'order', 'enabled', 
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'subject'       => 'required|string',
            'html_message'  => 'required|string',
            'order'         => 'integer',
            'enabled'       => 'required|boolean',
        ];
    }
}
