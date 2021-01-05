<?php
namespace App\Models\MobileApp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppMessage extends Model
{
    use SoftDeletes;

    protected $table = "app_messages";
    
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
        'message_types_id', 
        'link',
        'opened_at',
        'response_onesignal_api',
    ];

    protected $dates = [
        'deleted_at',
    ];
}