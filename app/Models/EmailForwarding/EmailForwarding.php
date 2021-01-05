<?php

namespace App\Models\EmailForwarding;

use App\Traits\ModelValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class EmailForwarding extends Model
{
    protected $table = "sweet.email_forwarding";

    use ModelValidatorTrait;
   
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
   
}
