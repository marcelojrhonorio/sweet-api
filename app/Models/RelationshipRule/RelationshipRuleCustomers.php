<?php

namespace App\Models\RelationshipRule;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class RelationshipRuleCustomers extends Model
{
    //
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
        'relationship_rule_id', 'customer_id',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'relationship_rule_id'       => 'required|integer',
            'customer_id'                => 'required|integer',
        ];
    }
}
