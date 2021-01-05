<?php

namespace App\Http\Controllers;

use App\ThirdPartyClient;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ThirdPartyAuthController extends Controller
{
    //
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a new token.
     *
     * @param  \App\ThirdPartyClient  $t
     * @return string
     */
    protected function jwt(ThirdPartyClient $t)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $t->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60, // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a client and return the token if the provided credentials are correct.
     *
     * @param  \App\ThirdPartyClient   $t
     * @return mixed
     */
    public function authenticate(ThirdPartyClient $t)
    {
        $this->validate($this->request, [
            'client_name' => 'required',
            'client_secret' => 'required',
        ]);

        // Find the user by email
        $t = ThirdPartyClient::where('client_name', $this->request->input('client_name'))->first();

        if (!$t) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'error' => 'Email does not exist.',
            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('client_secret'), $t->client_secret)) {
            return response()->json([
                'token' => $this->jwt($t),
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.',
        ], 400);
    }
}
