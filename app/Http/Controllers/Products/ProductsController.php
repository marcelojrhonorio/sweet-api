<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Products;

use DB;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\Stamp\Stamp;
use App\Models\Stamp\CustomerStamp;
use App\Models\ProductsServices;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ProductsServicesCategories;
use App\Models\Exchange\CustomerExchangedPoint;
use App\Models\ProductServiceStamp\ProductServiceStamp;

/**
 * @todo Add docs.
 */
class ProductsController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function findByCategory(Request $request, $category_id, $customerId)
    {

        $forbiddenProducts = $this->getForbiddenProducts($customerId);

        $category = ProductsServicesCategories::find($category_id);
        $products = ProductsServices::where('category_id', $category_id)
            ->where('status', 1)
            ->whereNotIn('id', $forbiddenProducts)
            ->get();

        if(env('STAMPS_REQUIRED'))
        {
            $all_stamps_required = [];

            foreach ($products as $product) {
                $product_stamps = ProductServiceStamp::where('product_id', $product->id)->select('id', 'stamps_id', 'product_id')->orderByDesc('id')->get();
                
                //selos dos produtos
                $array_stamps = [];

                //selos não conquistados
                $noStamp = [];
                
                //pegar informações das stamp de cada produto
                foreach ($product_stamps as $product_stamp) 
                {
                    $stamp = Stamp::find($product_stamp->stamps_id);

                    $res = CustomerStamp::where('customers_id', $customerId)->where('stamps_id', $stamp->id)->select('id', 'customers_id', 'stamps_id', 'count_to_stamp')->first();
                     
                    if($res) 
                    {
                       //ainda não conquistou o selo
                        if($stamp->required_amount != $res->count_to_stamp){
                            //selos não conquistados
                            array_push($noStamp, $stamp);
                        } 
                    }
                    //se não tiver customer_stamp  
                    else {
                        //selos não conquistados
                        array_push($noStamp, $stamp);
                    }

                    //selos dos produtos
                    array_push($array_stamps, $stamp);
                }

                //se não tiver TODOS os selos exigidos, marca a flag
                $statusStamps = true;
                if(0 != count($noStamp)){
                    $statusStamps = false;
                }                 
                
                $stamp_product = [
                    'product_id' => $product->id,
                    'stamps' => $array_stamps,
                    'qtd_stamps' => count($array_stamps),
                    'status_stamp' => $statusStamps,
                ];
                   
                //array de todos os produtos com todas suas stamps
                array_push($all_stamps_required, $stamp_product);               
            }

            return [
                'category' => $category,
                'products' => $products,
                'stamps'   => $all_stamps_required,
            ];
            
        }//env verify

        return [
            'category' => $category,
            'products' => $products,
            'stamps'   => [],
        ];
    }

    /**
     * @todo Add docs.
     */
    public function findByPriceRange(Request $request, $priceMin = '1', $priceMax = '1', $customerId)
    {
        if ($priceMax < $priceMin && '0' !== $priceMax) {
            $priceMax = $priceMin;
        }

        $forbiddenProducts = $this->getForbiddenProducts($customerId);
        
        $products = ProductsServices::where('points', '>=', $priceMin)
            ->when($priceMax, function ($query) use ($priceMax) {
                return $query->where('points', '<=', $priceMax);
            })
            ->where('status', 1)
            ->whereNotIn('id', $forbiddenProducts)
            ->get();

            if(env('STAMPS_REQUIRED'))
            {
                $all_stamps_required = [];
    
                //pegar informações das stamp de cada produto
                foreach ($products as $product) {
                    $product_stamps = ProductServiceStamp::where('product_id', $product->id)->select('id', 'stamps_id', 'product_id')->orderByDesc('id')->get();
                  
                    //selos dos produtos
                    $array_stamps = [];

                    //selos não conquistados
                    $noStamp = [];
                        
                    foreach ($product_stamps as $product_stamp) {
                        $stamp = Stamp::find($product_stamp->stamps_id);
                        $res = CustomerStamp::where('customers_id', $customerId)->where('stamps_id', $stamp->id)->select('id', 'customers_id', 'stamps_id', 'count_to_stamp')->first();
                     
                        if($res)
                        {
                            //ainda não conquistou o selo
                            if($stamp->required_amount != $res->count_to_stamp){
                                //selos não conquistados
                                array_push($noStamp, $stamp);
                            } 
                        }
                        //se não tiver customer_stamp 
                        else {
                            //selos não conquistados
                            array_push($noStamp, $stamp);
                        }
                        
                        //selos dos produtos
                        array_push($array_stamps, $stamp);
                    }

                    //se não tiver TODOS os selos exigidos, marca a flag
                    $statusStamps = true;
                    if(0 != count($noStamp)){
                        $statusStamps = false;
                    }    
                    
                    $stamp_product = [
                        'product_id' => $product->id,
                        'stamps' => $array_stamps,
                        'qtd_stamps' => count($array_stamps),
                        'status_stamp' => $statusStamps,
                    ];
                      
                    //array de todos os produtos com todas suas stamps
                    array_push($all_stamps_required, $stamp_product);
                }
    
                return [
                    'products' => $products,
                    'stamps'   => $all_stamps_required,
                ];
                
            }//env verify

            return [
                'products' => $products,
                'stamps'   => [],
            ];
    }

    private function getForbiddenProducts ($customerId) {

        $forbiddenProducts = DB::table('products_services')
            ->join('customer_exchanged_points', 
                   'products_services.id', '=', 
                   'customer_exchanged_points.product_services_id')
            ->where([
                ['customer_exchanged_points.customers_id', '=', $customerId],
                ['products_services.unique_exchange', '=', 1],
                ['products_services.status', '=', 1],
        ])->select('products_services.id')->get();

        $forbiddenProducts = json_decode($forbiddenProducts, true);

        return $forbiddenProducts;
    }
}
