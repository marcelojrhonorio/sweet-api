<?php

namespace App\Models\IncentiveEmails;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CheckinIncentiveEmail extends Model
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
    protected $fillable = ['incentive_emails_id', 'customers_id', 'points'];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = env('DB_CONNECTION', 'mysql');
        $this->rules = [
            'incentive_emails_id' => 'required|exists'.env('DB_CONNECTION', 'mysql').'.incentive_emails,id',
            'customers_id'        => 'required|exists'.env('DB_CONNECTION', 'mysql').'.customers,id',
            'points'              => 'required|integer',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Customers', 'customers_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incentive_emails(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\IncentiveEmails\IncentiveEmail', 'incentive_emails_id', 'id');
    }    
}
