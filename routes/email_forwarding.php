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
$router->group(['prefix' => 'api/email-forwarding/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {        
        $router->get('/email-forwarding', 'EmailForwarding\EmailForwardingController@index');
        $router->get('/email-forwarding/{id}', 'EmailForwarding\EmailForwardingController@show');
        $router->post('/email-forwarding', 'EmailForwarding\EmailForwardingController@store');
        $router->post('/email-forwarding/create', 'EmailForwarding\EmailForwardingController@create');
        $router->put('/email-forwarding/{id}', 'EmailForwarding\EmailForwardingController@update');       
            
        $router->get('/customers-forwarding', 'EmailForwarding\CustomersForwardingController@index');
        $router->get('/customers-forwarding/{id}', 'EmailForwarding\CustomersForwardingController@show');
        $router->post('/customers-forwarding', 'EmailForwarding\CustomersForwardingController@store');
        $router->post('/customers-forwarding/create', 'EmailForwarding\CustomersForwardingController@create');
        $router->put('/customers-forwarding/{id}', 'EmailForwarding\CustomersForwardingController@update');        
            
        $router->get('/customers-forwarding-email', 'EmailForwarding\CustomersForwardingEmailController@index');
        $router->get('/customers-forwarding-email/{id}', 'EmailForwarding\CustomersForwardingEmailController@show');
        $router->post('/customers-forwarding-email', 'EmailForwarding\CustomersForwardingEmailController@store');
        $router->post('/customers-forwarding-email/create', 'EmailForwarding\CustomersForwardingEmailController@create');
        $router->put('/customers-forwarding-email/{id}', 'EmailForwarding\CustomersForwardingEmailController@update');        
            
        $router->get('/customers-forwarding-print', 'EmailForwarding\CustomersForwardingPrintController@index');
        $router->get('/customers-forwarding-print/{id}', 'EmailForwarding\CustomersForwardingPrintController@show');
        $router->post('/customers-forwarding-print', 'EmailForwarding\CustomersForwardingPrintController@store');
        $router->post('/customers-forwarding-print/create', 'EmailForwarding\CustomersForwardingPrintController@create');
        $router->put('/customers-forwarding-print/{id}', 'EmailForwarding\CustomersForwardingPrintController@update');  
        
        $router->get('/customers-forwarding-status', 'EmailForwarding\CustomersForwardingStatusController@index');
        $router->get('/customers-forwarding-status/{id}', 'EmailForwarding\CustomersForwardingStatusController@show');
        $router->post('/customers-forwarding-status', 'EmailForwarding\CustomersForwardingStatusController@store');
        $router->post('/customers-forwarding-status/create', 'EmailForwarding\CustomersForwardingStatusController@create');
        $router->put('/customers-forwarding-status/{id}', 'EmailForwarding\CustomersForwardingStatusController@update');        
    });
});