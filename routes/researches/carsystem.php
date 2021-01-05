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
$router->group(['prefix' => 'api/carsystem/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'Carsystem\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'Carsystem\ResearchQuestionsController@show');             
        $router->post('/research-question', 'Carsystem\ResearchQuestionsController@store');

        $router->get('/research-option', 'Carsystem\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'Carsystem\ResearchOptionsController@show');             
        $router->post('/research-option', 'Carsystem\ResearchOptionsController@store');

        $router->get('/research-answer', 'Carsystem\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'Carsystem\ResearchAnswersController@show');             
        $router->post('/research-answer', 'Carsystem\ResearchAnswersController@store');        
    });
});