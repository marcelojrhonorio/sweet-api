<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActionCategory;
use App\Http\Controllers\Controller;

/**
 * @todo Add docs.
 */
class ActionsCategoryController extends Controller
{
    /**
     * @todo Add docs.
     */
    protected $rules = [
        'name' => 'required|string',
    ];

    /**
     * @todo Add docs.
     */
    public function __construct()
    {}

    /**
     * @todo Add docs.
     */
    public function index()
    {
        $model = ActionCategory::where('id', '>', '0')->orderBy('display_order')->get();

        return response()->json([
            'success' => true,
            'data'    => $model,
        ], 200);
    }

    /**
     * @todo Add docs.
     */
    public function show($id)
    {
        if (is_null($model)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid ActionCategory resource.'],
                'data'    => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $model,
        ], 200);
    }

    /**
     * @todo Add docs.
     */
    public function store(Request $request)
    {}

    /**
     * @todo Add docs.
     */
    public function update(Request $request, $id)
    {}

    /**
     * @todo Add docs.
     */
    public function destroy($id)
    {}
}
