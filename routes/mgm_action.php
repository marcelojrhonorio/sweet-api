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
$router->group(['prefix' => 'api/share-action/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->group(['prefix' => '/share-action'], function () use ($router) {
            $router->get('/', 'MemberGetMemberAction\MemberGetMemberActionController@index');
            $router->get('/{id}', 'MemberGetMemberAction\MemberGetMemberActionController@show');
            $router->post('/', 'MemberGetMemberAction\MemberGetMemberActionController@store');  
            $router->put('/{id}', 'MemberGetMemberAction\MemberGetMemberActionController@update');         
        });
    });
});
