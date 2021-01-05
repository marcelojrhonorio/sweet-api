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
$router->group(['prefix' => 'api/incentive/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/incentive-emails', 'IncentiveEmails\IncentiveEmailsController@index');
        $router->get('/incentive-emails/{id}', 'IncentiveEmails\IncentiveEmailsController@show');
        $router->post('/incentive-emails', 'IncentiveEmails\IncentiveEmailsController@store');
        $router->put('/incentive-emails/{id}', 'IncentiveEmails\IncentiveEmailsController@update');

        $router->get('/checkin', 'IncentiveEmails\CheckinIncentiveEmailsController@index');
        $router->get('/checkin/{id}', 'IncentiveEmails\CheckinIncentiveEmailsController@show');
        $router->post('/checkin', 'IncentiveEmails\CheckinIncentiveEmailsController@store');
        $router->put('/checkin/{id}', 'IncentiveEmails\CheckinIncentiveEmailsController@update');
    });
});
