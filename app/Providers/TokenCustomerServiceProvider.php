<?php

namespace App\Providers;

use App\Models\Customers;
use App\Repositories\ResourcesCampaignsRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;


class TokenCustomerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    static public function validate($request)
    {
       if ($request->header('app-token')) {
            $key = explode(' ',$request->header('app-token'));
            $customer = Customers::where('token', $key[1])->first();
            if (!empty($customer)) {
                $request->request->add(['customer_id' => $customer->id]);
            }
            return $customer;
        }
    }
}

