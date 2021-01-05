<?php

namespace App\Models\Researches;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MiddlePage extends Model
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
        'title', 'description', 'image_path', 'redirect_link',
    ];

    private $rules;

    private $errors;
    
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_RESEARCHES', 'researches_mysql');
        $this->rules = [
            'title'          => 'required|string',
            'description'    => 'required|string',
            'image_path'     => 'required|string',
            'redirect_link'  => 'required|string',
        ];
    }

    protected $dates = ['deleted_at'];
}