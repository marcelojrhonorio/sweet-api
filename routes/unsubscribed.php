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
$router->group(['prefix' => 'api/unsubscribed/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->group(['prefix' => 'unsubscribed-customers'], function () use ($router) {
            $router->get('/', 'UnsubscribedCustomersController@index');
            $router->get('/{id}', 'UnsubscribedCustomersController@show');
            $router->post('/', 'UnsubscribedCustomersController@store');
            $router->put('/{id}', 'UnsubscribedCustomersController@update');
        });
    });
});