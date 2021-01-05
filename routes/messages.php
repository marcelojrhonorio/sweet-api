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
$router->group(['prefix' => 'api/messages/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->group(['prefix' => 'customer-messages'], function () use ($router) {
            $router->post('/{id}', 'Messages\CustomerMessagesController@getMessageById');
            $router->post('/opened/{messageId}/{customerId}', 'Messages\CustomerMessagesController@readMessage');
            $router->delete('/delete/{messageId}/{customerId}', 'Messages\CustomerMessagesController@destroyMessage');
        });
    });
});