<?php

namespace App\Models\SeguroAuto;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class CustomerResearchAnswers extends Model
{
    use ModelValidatorTrait;

    //
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
        'customer_research_answer_has_insurance',
        'customer_research_answer_status_sicronized',
        'customer_research_answer_date_insurace_at',
        'customer_research_id', 
        'model_year_id',
        'insurance_company_id',
    ];

    private $rules;

    private $errors;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql');
        $this->rules =
            [
            'customer_research_answer_has_insurance' => 'required|boolean',
            'customer_research_answer_status_sicronized' => 'required|integer',
            'customer_research_answer_date_insurace_at' => 'sometimes|size:6|string',
            'customer_research_id' => 'required|exists:' . env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql') . '.customer_researches,id',
            'insurance_company_id' => 'sometimes|exists:' . env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql') . '.insurance_companys,id',
            'model_year_id' => 'required|exists:' . env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql') . '.model_years,id',

        ];
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model_year(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\ModelYears', 'model_year_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insurance_company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\InsuranceCompanys', 'insurance_company_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer_research(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\SeguroAuto\CustomerResearches', 'customer_research_id', 'id');
    }
}
