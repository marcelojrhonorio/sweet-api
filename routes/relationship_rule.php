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
$router->group(['prefix' => 'api/relationship/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/relationship-rule', 'RelationshipRule\RelationshipRulesController@index');
        $router->get('/relationship-rule/{id}', 'RelationshipRule\RelationshipRulesController@show');
        $router->post('/relationship-rule', 'RelationshipRule\RelationshipRulesController@store');
        $router->put('/relationship-rule', 'RelationshipRule\RelationshipRulesController@update');
    });
});