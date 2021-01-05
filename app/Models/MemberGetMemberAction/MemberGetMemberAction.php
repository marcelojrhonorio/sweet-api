<?php

namespace App\Models\MemberGetMemberAction;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class MemberGetMemberAction extends Model
{
    protected $table = "member_get_member_action";

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
        'customers_id', 
        'indicated_by',
        'action_id',
        'action_type',
        'won_points',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'customers_id'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'indicated_by'         => 'required|exists:'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'action_type'          => 'required|string',
            'action_id'            => 'required|integer',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function indicated_by(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }  

}
