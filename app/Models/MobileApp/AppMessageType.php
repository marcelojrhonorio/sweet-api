<?php

namespace App\Models\MobileApp;

use Illuminate\Database\Eloquent\Model;

class AppMessageType extends Model
{
    protected $table = "app_message_types";

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
        'image_path', 
        'text', 
        'push_title', 
        'push_text', 
    ];
}
