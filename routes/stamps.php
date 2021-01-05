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
$router->group(['prefix' => 'api/stamps/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/stamps', 'Stamp\StampsController@index');
        $router->get('/stamps/{id}', 'Stamp\StampsController@show');
        $router->post('/stamps', 'Stamp\StampsController@store');
        $router->put('/stamps/{id}', 'Stamp\StampsController@update');

        $router->get('/customer-stamps', 'Stamp\CustomerStampsController@index');
        $router->get('/customer-stamps/{id}', 'Stamp\CustomerStampsController@show');
        $router->post('/customer-stamps', 'Stamp\CustomerStampsController@store');
        $router->put('/customer-stamps/{id}', 'Stamp\CustomerStampsController@update');
    });
});