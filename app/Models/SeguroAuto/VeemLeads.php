<?php

namespace App\Models\SeguroAuto;

use Illuminate\Database\Eloquent\Model;

class VeemLeads extends Model
{
    //
    protected $table = 'v_veem_lead';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->connection = env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql');
    }
}
