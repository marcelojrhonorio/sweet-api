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
$router->group(['prefix' => 'api/quiz/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'Quiz\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'Quiz\ResearchQuestionsController@show');             
        $router->post('/research-question', 'Quiz\ResearchQuestionsController@store');

        $router->get('/research-option', 'Quiz\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'Quiz\ResearchOptionsController@show');             
        $router->post('/research-option', 'Quiz\ResearchOptionsController@store');
    });
});
