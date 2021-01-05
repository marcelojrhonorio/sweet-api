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
$router->group(['prefix' => 'api/exchange/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->group(['prefix' => '/exchanged-points'], function () use ($router) {
            $router->get('/', 'Exchange\CustomerExchangedPointsController@index');
            $router->get('/{id}', 'Exchange\CustomerExchangedPointsController@show');
            $router->post('/', 'Exchange\CustomerExchangedPointsController@store');  
            $router->post('/get-last-exchange', 'Exchange\CustomerExchangedPointsController@getLastExchange');  
            $router->put('/{id}', 'Exchange\CustomerExchangedPointsController@update');          
        });

        $router->group(['prefix' => '/exchanged-points-sm'], function () use ($router) {
            $router->get('/', 'Exchange\CustomerExchangedPointsSmController@index');
            $router->get('/{id}', 'Exchange\CustomerExchangedPointsSmController@show');
            $router->post('/verify-link', 'Exchange\CustomerExchangedPointsSmController@verifyLink');
            $router->post('/', 'Exchange\CustomerExchangedPointsSmController@create');  
            $router->put('/{id}', 'Exchange\CustomerExchangedPointsSmController@update');          
        });
    });
});
