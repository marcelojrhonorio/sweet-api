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
$router->group(['prefix' => 'api/app-message/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {      
        $router->get('/search/{customerId}', 'MobileApp\Messages\MessagesController@search');    
        $router->post('/read/{customerId}/{messageId}', 'MobileApp\Messages\MessagesController@read');    
        $router->delete('/destroy/{customerId}/{messageId}', 'MobileApp\Messages\MessagesController@destroy');
        $router->get('/test/{customerId}/{type}', 'MobileApp\Messages\MessagesController@test');
        $router->get('/get-message/{messageId}', 'MobileApp\Messages\MessagesController@getMessage');
    });
});