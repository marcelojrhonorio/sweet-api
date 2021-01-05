<?php
/**
 * Created by PhpStorm.
 * User: smithjunior
 * Date: 08/11/18
 * Time: 15:21
 */

namespace App\Services;


use App\Models\Customers;
use Carbon\Carbon;

class FacebookService
{
    public static function verifyCustomer(int $customer_id = null, int $facebook_id=null)
    {
        $c = Customers::find($customer_id);
        if($facebook_id === $c->facebook_id)
        {
            return false;
        }
        return true;
    }

    public static function syncFacebook(int $customer_id = null, int $facebook_id=null)
    {
        $c = Customers::find($customer_id);
        $c->facebook_id = $facebook_id;
        $c->facebook_sync_at = Carbon::now();
        $c->points+=50;
        return $c->update();
    }
}
