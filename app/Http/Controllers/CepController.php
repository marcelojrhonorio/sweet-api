<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers;

use App\Models\BrazilCep;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @todo Add docs.
 */
class CepController extends BaseController
{
    /**
     * @todo Add docs.
     */
    public function __construct()
    {}

    /**
     * @todo Add docs.
     */
    public function show(Request $request, $cep)
    {
        $local = BrazilCep::where('cep', $cep)->first();

        if (is_null($local)) {
            return response()->json([
                'success' => false,
                'data'    => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => $local,
        ]);
    }
}
