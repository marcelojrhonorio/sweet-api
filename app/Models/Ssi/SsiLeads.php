<?php

namespace App\Models\Ssi;

use Illuminate\Database\Eloquent\Model;

class SsiLeads extends Model
{
    //

    protected $table = 'v_ssi_lead';

    protected $hidden = ["customer_id"];

    public function getGenderAttribute()
    {
        return ("M" === $this->attributes['gender']) ? ["id" => "1", "value" => "Masculino"] : ["id" => "2", "value" => "Feminino"];
    }
}
