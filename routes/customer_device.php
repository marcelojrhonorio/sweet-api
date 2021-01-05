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
$router->group(['prefix' => 'api/customer-device/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/customer-device', 'CustomerDevicesController@index');
        $router->get('/customer-device/{id}', 'CustomerDevicesController@show');
        $router->post('/customer-device', 'CustomerDevicesController@store');
        $router->put('/customer-device/{id}', 'CustomerDevicesController@update');
    });
});