<?php

namespace App\Http\Controllers\ProductServiceStamps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ProductServiceStamp\ProductServiceStamp;

class ProductServiceStampsController extends Controller
{
    use \App\Traits\ApiControllerTrait;

    protected $model;
    protected $relationships = ['stamp', 'product'];
    
    public function __construct(ProductServiceStamp $model)
    {
        $this->model = $model;
    }  

    public function delete(Request $request)
    {
       $product_stamp = ProductServiceStamp::where('product_id', $request->id)->select('id', 'stamps_id', 'product_id')->orderByDesc('id')->get();
                
        if(empty($product_stamp)){
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid.'],
                'data'    => [],
            ], 404);            
        }
        
        foreach($product_stamp as $product){
            $product->delete();
        }

        return response()->json([
            'success' => true,       
        ], 200);  

    }

}
