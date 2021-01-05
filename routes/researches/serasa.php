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
$router->group(['prefix' => 'api/serasa/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'Serasa\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'Serasa\ResearchQuestionsController@show');             
        $router->post('/research-question', 'Serasa\ResearchQuestionsController@store');

        $router->get('/research-option', 'Serasa\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'Serasa\ResearchOptionsController@show');             
        $router->post('/research-option', 'Serasa\ResearchOptionsController@store');

        $router->get('/research-answer', 'Serasa\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'Serasa\ResearchAnswersController@show');             
        $router->post('/research-answer', 'Serasa\ResearchAnswersController@store');        
    });
});