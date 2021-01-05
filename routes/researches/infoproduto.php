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
$router->group(['prefix' => 'api/infoproduto/v1'], function () use ($router) {
    $router->group(['prefix' => 'frontend'], function () use ($router) {
        $router->get('/research-question', 'Infoproduto\ResearchQuestionsController@index');
        $router->get('/research-question/{id}', 'Infoproduto\ResearchQuestionsController@show');             
        $router->post('/research-question', 'Infoproduto\ResearchQuestionsController@store');

        $router->get('/research-option', 'Infoproduto\ResearchOptionsController@index');
        $router->get('/research-option/{id}', 'Infoproduto\ResearchOptionsController@show');             
        $router->post('/research-option', 'Infoproduto\ResearchOptionsController@store');

        $router->get('/research-answer', 'Infoproduto\ResearchAnswersController@index');
        $router->get('/research-answer/{id}', 'Infoproduto\ResearchAnswersController@show');             
        $router->post('/research-answer', 'Infoproduto\ResearchAnswersController@store');        
    });
});