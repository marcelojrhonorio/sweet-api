<?php

namespace App\Http\Controllers\Exchange;

use Log;
use App\Models\Action;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\ProductsServices;
use App\Http\Controllers\Controller;
use App\Models\Exchange\CustomerExchangedPointsSm;

class CustomerExchangedPointsSmController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['customer', 'product_service'];
    
    public function __construct(CustomerExchangedPointsSm $model)
    {
        $this->model = $model;
    }    

    public function create(Request $request)
    {
        $product_services_id = $request->input('products_services_id');
        $social_media = $request->input('social_media');
        $customers_id = $request->input('customers_id');
        $subject = $request->input('subject');
        $profile_link = $request->input('profile_link');
        $points = $request->input('points');
        $profile_picture = $request->input('profile_picture');
        $status = $request->input('status');

        $customerExchangedPointsSm = new CustomerExchangedPointsSm();
        $customerExchangedPointsSm->product_services_id = $product_services_id;
        $customerExchangedPointsSm->social_media = $social_media;
        $customerExchangedPointsSm->customers_id = $customers_id;
        $customerExchangedPointsSm->subject = $subject;
        $customerExchangedPointsSm->profile_link = $profile_link;
        $customerExchangedPointsSm->points = $points;
        $customerExchangedPointsSm->profile_picture = $profile_picture;
        $customerExchangedPointsSm->status = $status;
        $customerExchangedPointsSm->save();

        $customer = Customers::find($customers_id) ?? null;
        
        if($customer) {
            $customer->points = $customer->points - $points;
            $customer->update();
        }

        return response()->json([
            'success' => true,
            'customerExchangedPointsSm' => $customerExchangedPointsSm,
            'customer' => $customer,
        ]);
        
    }

    public function verifyLink(Request $request)
    {
        $profile_link = $request->input('profile_link');

        $customerExchangedPointsSm = CustomerExchangedPointsSm::where('profile_link', $profile_link)->first() ?? null;

        if($customerExchangedPointsSm) 
        {
            if('pending' == $customerExchangedPointsSm->status) {
                return response()->json([
                    'success' => true,
                    'message' => 'Você possui uma solicitação pendente com link informado. Por favor, aguarde nossa verificação.',
                ]);  
            }

            $action = Action::where('exchange_id', $customerExchangedPointsSm->id)->first() ?? null;

            if($action && $action->enabled) 
            {
                $productsServices = ProductsServices::where('id', $customerExchangedPointsSm->product_services_id)->first() ?? null;

                if($productsServices) 
                {
                    $date = $action->created_at;                 
                    $date = $date->addDays($productsServices->exibition_time);

                    $edit1 = explode(" ", $date);
                    $data = $edit1[0];
                    $hora = $edit1[1];

                    $edit2 = explode("-", $data);                    

                    $day = $edit2[2];
                    $month = $edit2[1];
                    $year = $edit2[0];

                    $message = "O link informado possui uma exibição no portal SweetBonus até " . $day . '/' . $month . '/' . $year . ' às ' . $hora . '. Por favor, informe outro link ou aguarde até finalizar a exibição.';
                    
                    return response()->json([
                        'success' => true,
                        'message' => $message,
                    ]);                    
                }
                
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => '',
            ]);   
        }
    }
}
