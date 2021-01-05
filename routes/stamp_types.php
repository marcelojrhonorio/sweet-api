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
$router->group(['prefix' => 'api/stamp-types/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/stamp-types', 'StampType\StampTypesController@index');
        $router->get('/stamp-types/{id}', 'StampType\StampTypesController@show');
        $router->post('/stamp-types', 'StampType\StampTypesController@store');
        $router->put('/stamp-types/{id}', 'StampType\StampTypesController@update');
    });
});