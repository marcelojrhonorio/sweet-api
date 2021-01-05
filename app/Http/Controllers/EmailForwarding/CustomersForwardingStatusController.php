<?php

namespace App\Http\Controllers\EmailForwarding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailForwarding\CustomersForwardingStatus;

class CustomersForwardingStatusController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer'];
    
    public function __construct(CustomersForwardingStatus $model)
    {
        $this->model = $model;
    }  

    public function create(Request $request)
    {
        $customers_id = $request->input('customers_id');
        $email = $request->input('email');
        $name = $request->input('name');

        $cFStatus = self::verifyCustomersForwardingStatus($customers_id);

        if($cFStatus) {
            $cFStatus->status = false;
            $cFStatus->update();
            return $cFStatus;
        }

        $customersForwardingStatus = new CustomersForwardingStatus;
        $customersForwardingStatus->customers_id = $customers_id;
        $customersForwardingStatus->name = $name;
        $customersForwardingStatus->email = $email;
        $customersForwardingStatus->status = false;
        $customersForwardingStatus->save();

        return $customersForwardingStatus;
    }

    private static function  verifyCustomersForwardingStatus($customers_id)
    {
        $customersForwardingStatus = CustomersForwardingStatus::where('customers_id', $customers_id)->first() ?? null;

        return $customersForwardingStatus;
    }

}
