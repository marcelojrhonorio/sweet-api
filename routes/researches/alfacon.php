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
$router->group(['prefix' => 'api/alfacon/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'Alfacon\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'Alfacon\ResearchQuestionsController@show');             
        $router->post('/research-question', 'Alfacon\ResearchQuestionsController@store');

        $router->get('/research-option', 'Alfacon\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'Alfacon\ResearchOptionsController@show');             
        $router->post('/research-option', 'Alfacon\ResearchOptionsController@store');

        $router->get('/research-answer', 'Alfacon\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'Alfacon\ResearchAnswersController@show');             
        $router->post('/research-answer', 'Alfacon\ResearchAnswersController@store');

        $router->get('/lead-response', 'Alfacon\LeadResponsesController@index');
        $router->get('/lead-response/{id}', 'Alfacon\LeadResponsesController@show');             
        $router->post('/lead-response', 'Alfacon\LeadResponsesController@store');
    });
});