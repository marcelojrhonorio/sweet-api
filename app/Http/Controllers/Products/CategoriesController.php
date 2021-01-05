<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductsServicesCategories;

/**
 * @todo Add docs.
 */
class CategoriesController extends Controller
{
    /**
     * @todo Add docs.
     */
    public function all(Request $request)
    {
        $categories = ProductsServicesCategories::all();
        $filtered   = $categories->map(function($category) { return $category->only(['id', 'name']); })->all();

        return $filtered;
    }
}
