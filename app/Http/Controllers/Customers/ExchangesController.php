<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Customers;

use DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\ProductsServices;
use Illuminate\Http\Request;

/**
 * @todo Add docs.
 */
class ExchangesController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function closestExchanges(Request $request, $customerId)
    {
        $customer = Customers::find($customerId);
        $points = $customer->points ?? 0;

        $forbiddenProducts = $this->getForbiddenProducts($customerId);
        
        $closest = ProductsServices::where('points', '>=', $points)
            ->where('status', 1)
            ->whereNotIn('id', $forbiddenProducts)
            ->orderBy('points', 'asc')
            ->take(4)
            ->get();
        
        return $closest;
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
