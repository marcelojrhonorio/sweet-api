<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */
$router->group(['prefix' => 'api/customer-address/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->group(['prefix' => '/customer-address'], function () use ($router) {
            $router->get('/', 'Customers\CustomerAddressController@index');
            $router->get('/{id}', 'Customers\CustomerAddressController@show');
            $router->post('/', 'Customers\CustomerAddressController@store');  
            $router->put('/{id}', 'Customers\CustomerAddressController@update');         
        });
    });
});
