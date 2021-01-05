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
$router->post('thirdparty-auth/login', ['uses' => 'ThirdPartyAuthController@authenticate']);

$router->group(['prefix' => 'api/ssi/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/ssi-leads', 'Ssi\SsiLeadsController@index');
        $router->get('/ssi-leads/{id}', 'Ssi\SsiLeadsController@show');
        $router->get('/ssi-projects', 'Ssi\SsiProjectsController@index');
        $router->get('/ssi-respondent', 'Ssi\SSiRespondentsController@index');
        $router->put('/ssi-respondent/{id}', 'Ssi\SSiRespondentsController@update');
        $router->get('/pixel_opened_email/{respondent_id}', 'Ssi\SSiRespondentsController@registerPixel');
    });

    $router->group(['prefix' => 'thirdpartyclient', 'middleware' => ['ip.ssi.check']], function () use ($router) {
        $router->get('/ssi-leads', 'Ssi\SsiLeadsController@index');
        $router->post('/ssi-leads', 'Ssi\SsiLeadsController@showRespondentStatus');
    });
});

$router->group(['prefix' => 'api/customers-invites/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/invites', 'CustomerInvitesController@index');
    });
});
