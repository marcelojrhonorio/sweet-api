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
$router->group(['prefix' => 'api/app-auth/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {        
        $router->post('/login', 'MobileApp\Auth\LoginController@login');
        $router->post('/logout', 'MobileApp\Auth\LogoutController@logout');      
        $router->post('/click-login', 'MobileApp\Auth\ClickLoginController@clickLogin');      
        $router->post('/verify-invite/{customerId}', 'MobileApp\Auth\InviteAppController@verfiyInviteApp'); 
        $router->post('/create-waiting-list/{customerId}', 'MobileApp\Auth\InviteAppController@createWaitingList'); 
    });
});

