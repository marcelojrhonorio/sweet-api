<?php

namespace App\Http\Controllers\MobileApp\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppNotification;

class NotificationController extends Controller
{
    protected $model;
    
    public function __construct(AppNotification $model)
    {
        $this->model = $model;
    }
}
